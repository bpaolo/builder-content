/**
 * Created by rhenan.dinardi 30/10/2018
 */
function Likert (identificador, idQuestContainer, answer, atvLivre, feedAcerto, feedErro, config, elementos) {

    //Id do elemento que contem todas as questão da atividade.
    this.idQuestContainer = idQuestContainer;
    this.feedAcerto = feedAcerto || "Parabéns! você acertou todas as alternativas.";
    this.feedErro = feedErro || "Existe(m) uma(s) alternativa(s) incorreta(s)";

    //Resposta da atividade.
    this.answer = answer;
    //variavel de configuração da atividade
    this.configAtv = config;

    this.atvLivre = atvLivre || false;

    //objeto para ser salvo como respostas do cursista
    this.saveData = {
        "identificador": identificador + "_q01",
        "gabaritos": []
    };

    this.atividade = {
        "identificador": identificador,
        "questoes": [this.saveData]
    };

    this.btnConferir = $("#" + elementos.btnConferir);     // Pega o botão de Confirmação da Atividade
    this.btnRefazer = $("#"  + elementos.btnRefazer);    // Pega o botão de Refazer
    this.btnLimpar = $("#" + elementos.btnLimpar);
    this.feedback = $("#" + elementos.feed);     // Mensagem na tela

    //conferindo se o usuário pode refazer atividade
    this.declareResetVariables();

}

Likert.prototype.declareResetVariables = function __declareResetVariables() {

    completeOnExit = false;
    this.qtdSelect = 0;

    //Elemento que representa a laternativa selecionada.
    this.currentAlter = [];

    //Objeto com todos os elementos que definidos como alternativas.
    this.alternatives = $('#' + this.idQuestContainer + ' [role=radio]');
    this.countErros = 0;

    this.maskPopup = $('.mask-popup');
    this.closePopup = $('.close-popup');

    //Códigos das teclas de controle.
    this.keys = {
        enter: 13,
        space: 32,
        left: 37,
        up: 38,
        right: 39,
        down: 40
    };

    this.configAtv.showBtnConferir ? this.btnConferir.show() : this.btnConferir.hide();

    //Configurações iniciais.
    this.init();
};

Likert.prototype.AddEventMultQuestions = function () {

    var i, max = this.idQuestContainer.length, self = this;
    this.alternatives = {};
    for (i = 0; i < max; i++) {

        //Objeto com todos os elementos que definidos como alternativas.
        this.alternatives["p" + i] = $('#' + this.idQuestContainer[i] + ' [role=radio]');

        //Adicionando listeners de click em todas os elementos alternativa.
        this.alternatives["p" + i].bind('click', function (e) {
            e.preventDefault();
            self.onClickAlternatives(e);
        });

        //Adicionando listeners de tecla em todas os elementos alternativa.
        this.alternatives["p" + i].bind('keydown', function (e) { self.onKeyDownAlternatives(e); });

        //Definindo a propriedade "aria-label" para todos os elementos alternativa.
        $.each(this.alternatives["p" + i], function (index, alternative) {
            $(alternative).attr('aria-label', $(alternative).text());
        });

    }
};

/**
 * Configurações iniciais da atividade.
 */
Likert.prototype.init = function __init() {

    //
    var self = this;

    //this.btnConferir.bind('keydown', function (e) { self.onClickBtnCheck() });
    this.btnConferir.bind('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        self.onClickBtnCheck();
    });

    //this.btnRefazer.bind('keydown', function (e) { self.onClickbtnRefazer(e); });
    //Adicionando listeners de click nos botões.
    this.btnRefazer.bind('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        self.onClickbtnRefazer(e);
    });

    this.maskPopup.bind('keydown', function (e) { self.modalClose(e); });
    this.maskPopup.bind('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        self.modalClose(e);
    });

    this.closePopup.bind('keydown', function (e) { self.modalClose(e); });
    this.closePopup.bind('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        self.modalClose(e);
    });

    if (this.configAtv.showBtnClear)
        this.btnLimpar.show();

    if (this.configAtv.showBtnConferir)
        this.btnConferir.show();

    this.setEvent();

};//init

/**
 * Adicionand evento nos elemento.
 */
Likert.prototype.setEvent = function (e) {

    var self = this;

    //Apaga o texto de feedback e remove o atributo "role".
    this.feedback.text('').removeAttr('role', 'alert');

    this.btnRefazer.hide();

    if(Array.isArray(this.idQuestContainer)){
        this.AddEventMultQuestions();
        return;
    }

    //Definindo a propriedade "aria-label" para todos os elementos alternativa.
    $.each(this.alternatives, function (index, alternative) {
        $(alternative).attr('aria-label', $(alternative).text());
    });

    //Adicionando listeners de tecla em todas os elementos alternativa.
    this.alternatives.bind('keydown', function (e) { self.onKeyDownAlternatives(e); });
    //Adicionando listeners de click em todas os elementos alternativa.
    this.alternatives.bind('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        self.onClickAlternatives(e);
    });

};//setEvent

/**
 * Executa o feedback modal
 */
Likert.prototype.modalFeedBack = function __modalFeedBack(feed) {
    // remove todos os filhos do elemento text
    $(".text").children().remove();
    // add feed ao elemento text
    $(".text").append(feed);
    //comando que executa a chamada da pop-up
    Modal.launchWindow();
}//modalFeedBack

/**
 * Remove as opções que estiverem erradas deixando as certas selecionadas
 */
Likert.prototype.onClickBtnErradas = function __onClickBtnErradas(e) {

    var self = this, respCerta = [];

    for (var i = 0; i < this.currentAlter.length; i++) {

        if ($(this.currentAlter[i]).hasClass('feedErrado')) {
            //Remove possíveis feedbacks do texto da pripriedade "aria-label" do elemento selecionado.
            var ariaLabel = $(this.currentAlter[i]).attr('aria-label').replace(' Resposta certa.', '').replace(' Resposta errada.', '');
            this.qtdSelect--;
            //Remove classes css e atualiza propriedades WAI ARIA do elemento.
            $(this.currentAlter[i]).removeClass('ativo feedCerto feedErrado').attr({
                'aria-checked': 'false',
                'aria-label': ariaLabel
            });
        } else {
            respCerta.push(this.currentAlter[i]);
        }//else

    }//for

    this.currentAlter = [];
    this.currentAlter = respCerta;
    this.setEvent();
};//onClickBtnErradas

/**
 * Reinicia a atividade.
 */
Likert.prototype.onClickbtnRefazer = function __onClickbtnRefazer(e) {

    for (var i = 0; i < this.currentAlter.length; i++) {

        //Remove possíveis feedbacks do texto da pripriedade "aria-label" do elemento selecionado.
        var ariaLabel = $(this.currentAlter[i]).attr('aria-label').replace(' Resposta certa.', '').replace(' Resposta errada.', '');

        //Remove classes css e atualiza propriedades WAI ARIA do elemento.
        $(this.currentAlter[i]).removeClass('ativo feedCerto feedErrado').attr({
            'aria-checked': 'false',
            'aria-label': ariaLabel
        });
    }//for

    //Anula o objeto.
    this.currentAlter = [];
    this.qtdSelect = 0;
    this.setEvent();

};//onClickbtnRefazer

/**
 * Removendo elemento selecionado anteriormente
 */
Likert.prototype.removeElemento = function (element) {

    for (var i = 0; i < this.currentAlter.length; i++) {
        //remove se o elemento se ele foi igual o já existente dentro do array
        if (this.currentAlter[i] == element) {
            this.currentAlter.splice(i, 1);
        }//if
    }//for

};//removeElemento

/**
 * Fecha o feedback modal
 */
Likert.prototype.modalClose = function (e) {
    Modal.closeWindow(e);
};//modalClose

/**
 * Comportamento de teclas nas alternativas.
 */
Likert.prototype.onKeyDownAlternatives = function (e) {
    //impede a propagação do evento atual.
    e.stopPropagation();

    //Alternativa selecionada
    var $alternative = $(e.target);

    var $totalAlternatives = $(e.target).parent().find('[role=radio]');

    //Index da alternativa.
    var index = $totalAlternatives.index($alternative);

    //Alternativa anterior a questão selecionada.
    var prev_alter = $totalAlternatives[index - 1];

    //Alternativa posterior a questão selecionada.
    var next_alter = $totalAlternatives[index + 1];

    //Teclas ignoradas no código.
    if (e.altKey || e.shiftKey) return;

    switch (e.keyCode) {
        //Tecla espaço ou o enter de código 13...
        case this.keys.space:
        case this.keys.enter:

            //Não executa as seguintes instruções caso a tecla ctrl esteja pressionada.
            if (e.ctrlkey) return;

            //Executa o método responsável pelo comportamento de seleção de alternativa.
            this.onClickAlternatives(e);
        break;

        //Tecla seta para esquerda ou para cima, foca o elemento anterior a e.target.
        case this.keys.left:
        case this.keys.up:
            if((index -1) >= 0)
                prev_alter.focus();
        break;

        //Tecla seta para direita ou para baixo foca o elemento posterior a e.target.
        case this.keys.right:
        case this.keys.down:
            if( (index +1) < $totalAlternatives.length)
                next_alter.focus();
        break;
    }//switch

};//onKeyDownAlternatives

Likert.prototype.checkSelected = function (id) {

    var i = 0, max = this.currentAlter.length, elem;

    for (i = 0; i < max; i++) {
        elem = $(this.currentAlter[i]);

        if (id == elem.parent().parent().data("option")) {
            //Se existir um elemento anteriormente selecionado, ele tera a class css ativo removida e aria-checked atualizada com false.
            elem.removeClass('ativo').attr('aria-checked', 'false');
            this.currentAlter.splice(i, 1);
        }
    }

};

Likert.prototype.onClickAlternatives = function (e, _target) {

    var self = this;

    var elm = (_target) ? $(_target) : $(e.target);
    var domElm = (_target) ? $(_target)[0] : e.target;

    var id = elm.parent().parent().data("option");

    this.checkSelected(id);

    if (elm.hasClass('ativo') && this.answer[id].length > 1) {
        //Se existir um elemento anteriormente selecionado, ele tera a class css ativo removida e aria-checked atualizada com false.
        elm.removeClass('ativo').attr('aria-checked', 'false');
        this.qtdSelect--;
        this.removeElemento(e.target);

    } else if (this.answer[id].length == 1) {

        //Armazena o elemento selecionado e adicionada class css ativo e atualiza aria-checked com true.
        elm.addClass('ativo').attr('aria-checked', 'true');

        this.qtdSelect = 0;
        this.qtdSelect++;
        this.currentAlter.push(domElm);

    } else if (this.qtdSelect < this.answer[id].length) {
        //Armazena o elemento selecionado e adicionada class css ativo e atualicheckSelectedza aria-checked com true.
        elm.addClass('ativo').attr('aria-checked', 'true')
        this.currentAlter.push(domElm);
        this.qtdSelect++;
    }//else

    if (this.answer.length == this.currentAlter.length) {

        if (this.configAtv.autoCorrect) {
            self.onClickBtnCheck();
        }
        else {
            this.btnConferir.show();
            return;
        }

    }

}//onClickAlternatives

/**
 * Comportamento ao clicar em um elemento.
// */
//MultiplaEscolha.prototype.onClickAlternatives = function (e) {
//
//    var self = this;
//
//    this.checkSelected(id);
//
//    if ($(e.target).hasClass('ativo') && this.answer[id].length > 1) {
//    //if ($(e.target).hasClass('ativo') && this.answer.length > 1) {
//        //Se existir um elemento anteriormente selecionado, ele tera a class css ativo removida e aria-checked atualizada com false.
//        $(e.target).removeClass('ativo').attr('aria-checked', 'false');
//        this.qtdSelect--;
//        this.removeElemento(e.target);
//
//    //} else if (this.answer.length == 1) {
//    } else if (this.answer[id].length == 1) {
//
//        //Se existir um elemento anteriormente selecionado, ele tera a class css ativo removida e aria-checked atualizada com false.
//        $(this.currentAlter[0]).removeClass('ativo').attr('aria-checked', 'false');
//        //Armazena o elemento selecionado e adicionada class css ativo e atualiza aria-checked com true.
//        $(e.target).addClass('ativo').attr('aria-checked', 'true');
//
//        this.qtdSelect = 0;
//        this.qtdSelect++;
//        this.currentAlter = [];
//        this.currentAlter.push(e.target);
//
//    //} else if (this.qtdSelect < this.answer.length) {
//    } else if (this.qtdSelect < this.answer[id].length) {
//        //Armazena o elemento selecionado e adicionada class css ativo e atualiza aria-checked com true.
//        $(e.target).addClass('ativo').attr('aria-checked', 'true')
//        this.currentAlter.push(e.target);
//        this.qtdSelect++;
//    }//else
//
//
//
//    if (this.answer.length == this.currentAlter.length) {
//
//        if (this.configAtv.btnConfExist) {
//            this.btnConferir.show();
//            return;
//        }
//        self.onClickBtnCheck();
//
//    }
//
//};//onClickAlternatives

/**
* Correção da atividade.
*/
Likert.prototype.onClickBtnCheck = function (_noSave) {

    if(Array.isArray(this.idQuestContainer)){
        this.checkMuitAnswer(_noSave);
        return;
    }

    this.checkSingleAnswer(_noSave);

};//onClickBtnCheck

Likert.prototype.checkSingleAnswer = function __checkSingleAnswer(_noSave) {
    $(this.feedback).attr('opacity', '0');

    //Se alguma atividade foi selecionada.
    if (this.currentAlter.length > 0) {

        this.saveData.gabaritos = [];

        this.correto = 0;
        var resp, select_alter, label = "";


        for (var j = 0; j < this.answer.length; j++) {

            select_alter = this.alternatives.index(this.currentAlter[j]) + 1;

            resp = $(this.currentAlter[j]);
            //Armazenando o valor da propriedade aria-label.
            var ariaLabel = resp.attr('aria-label');

            //atualizando respostas do cursista para salvar
            self.saveData.gabaritos.push({"chave": (j+1), "valor": this.alternatives['p' + id].index(this.currentAlter[j]) || 0});

            if (this.atvLivre) {
                this.correto = this.answer.length;
            }
            else {

                for (var i = 0; i < this.answer.length; i++) {

                    if (select_alter == this.answer[i]) {
                        if (this.configAtv.showAnswer)
                            resp.attr('aria-label', ariaLabel + ' Resposta certa.').removeClass('ativo').addClass('feedCerto');
                        else
                            resp.removeClass('ativo');
                        this.correto++;
                    }//if

                }//for i

                if (resp.hasClass('ativo')) {
                    if (this.configAtv.showAnswer)
                        resp.attr('aria-label', ariaLabel + ' Resposta errada.').removeClass('ativo').addClass('feedErrado');
                    else
                        resp.removeClass('ativo');
                }//if
            }

        }//for j

        // //Se a resposta for certa ou errada, tanto a propriedade aria-label quanto o feedback serão atualizados com essa informação.
        if (this.correto == this.answer.length) {

            label = this.feedAcerto;


        } else {
            label = this.feedErro;
        }//else

        if(!_noSave)this.saveAnswer();

        //Esconde o botão de corrigir e exibe o de refazer.
        this.btnConferir.hide();
        this.btnRefazer.show();
        this.alternatives.unbind('click').unbind('keydown');

    } else {

        //Se nenhum elemento foi selecionado, o usuario recebe um alerta por feedback.
        label = 'Selecione uma alternativa.';
    }//else
    this.activeFeed(label);
};

Likert.prototype.checkMuitAnswer = function __checkMuitAnswer(_noSave) {
    $(this.feedback).attr('opacity', '0');
    var id, select_alter, ariaLabel, elem, label = "", self = this;
    //Se alguma atividade foi selecionada.
    if (this.currentAlter.length > 0 && this.currentAlter.length == this.answer.length) {

        this.correto = 0;

        this.saveData.gabaritos = [];

        for (var j = 0; j < this.answer.length; j++) {
            //Index da atividade selecionado acrescido em 1.( Por questão de praticidade para o gabarito. )
            // var select_alter = $( this.currentAlter[j] ).attr("data-opcao");
            id = $(this.currentAlter[j]).parent().parent().data("option");

            select_alter = this.alternatives['p' + id].index(this.currentAlter[j]) + 1;

            //atualizando respostas do cursista para salvar
            self.saveData.gabaritos.push({"chave": (j+1), "valor": this.alternatives['p' + id].index(this.currentAlter[j]) || 0});

            //Armazenando o valor da propriedade aria-label.
            ariaLabel = $(this.currentAlter[j]).attr('aria-label');

            if(this.atvLivre) {

                this.correto = this.answer.length;
            }
            else {
                for (var i = 0; i < this.answer[i].length; i++) {
                    elem = $(this.currentAlter[j]);
                    id = elem.parent().parent().data("option");
                    if (select_alter == this.answer[id][i]) {

                        if (this.configAtv.showAnswer)
                            elem.attr('aria-label', ariaLabel + ' Resposta certa.').removeClass('ativo').addClass('feedCerto');
                        else
                            elem.removeClass('ativo');
                        this.correto++;
                    }//if

                }//for i

                if (elem.hasClass('ativo')) {
                    elem.attr('aria-label', ariaLabel + ' Resposta errada.').removeClass('ativo').addClass('feedErrado');
                }//if
            }
        }//for j


        //console.log(this.correto, this.answer.length, "fim");
        // //Se a resposta for certa ou errada, tanto a propriedade aria-label quanto o feedback serão atualizados com essa informação.
        if (this.correto == this.answer.length) {

            label = this.feedAcerto;

        } else {
            this.addEventBtnRefazer(false);
            label = this.feedErro;
        }//else

        if(!_noSave) this.saveAnswer();

        //Esconde o botão de corrigir e exibe o de refazer.
        this.btnConferir.hide();
        this.btnRefazer.show();

        $.each(this.alternatives, function(index, alt){
            $(alt).unbind('click').unbind('keydown');
        })
        //$(".alternativa").unbind('click').unbind('keydown');
    } else {
        //Se nenhum elemento foi selecionado, o usuario recebe um alerta por feedback.
        label ='Selecione todas as alternativas.';
    }//else

    this.activeFeed(label);
};

Likert.prototype.activeFeed = function __activeFeed(label) {

    if (this.configAtv.feedModal) {
        $(".title-popup").addClass("activeFeed");
        this.modalFeedBack(label);
    } else {
        this.feedback.empty();
        this.feedback.html(label);
    }//else

    // Anima o alpha do texto de feedback
    this.feedback.animate({opacity: 1}, 1000);
    this.feedback.animate({opacity: 0}, 1000);
    this.feedback.animate({opacity: 1}, 1000);

    //Atualizando a propriedade "role" do elemento com o valor alert. Isso faz o leitor de tela focar no alerta.
    this.feedback.attr('role', '');
    this.feedback.attr('role', 'alert');
};

Likert.prototype.addEventBtnRefazer = function __addEventBtnRefazer(flag) {
    var self = this;
    this.btnRefazer.unbind('click');
    if(!flag){
        this.btnRefazer.bind('click', function (e) {
            e.preventDefault();
            self.onClickBtnErradas(e);
        });
    }else{
        this.btnRefazer.bind('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            self.onClickbtnRefazer(e);
        });
    }

};

/**
 * Remove as opções que estiverem erradas deixando as certas selecionadas
 */
Likert.prototype.onClickBtnErradas = function (e) {

    this.btnRefazer.hide();
    this.feedback.animate({opacity: 0}, 0);

    var self = this, respCerta = [], max = this.currentAlter.length, elem;

    for (var i = 0; i < max; i++) {

        if ($(this.currentAlter[i]).hasClass('feedErrado')) {
            this.countErros++;

            //Remove possíveis feedbacks do texto da pripriedade "aria-label" do elemento selecionado.
            var ariaLabel = $(this.currentAlter[i]).attr('aria-label').replace(' Resposta certa.', '').replace(' Resposta errada.', '');
            this.qtdSelect--;
            //Remove classes css e atualiza propriedades WAI ARIA do elemento.
            $(this.currentAlter[i]).removeClass('ativo feedCerto feedErrado').attr({
                'aria-checked': 'false',
                'aria-label': ariaLabel
            });

            var id = $(this.currentAlter[i]).parent().parent().data("option");

            this.alternatives["p" + id] = $('#' + this.idQuestContainer[id] + ' [role=radio]');

            elem = $(this.alternatives["p" + id]);
            elem.unbind('click').unbind('keydown');

            //Adicionando listeners de click em todas os elementos alternativa.
            elem.bind('click', function (e) {
                e.preventDefault();
                self.onClickAlternatives(e);
            });
            //Adicionando listeners de tecla em todas os elementos alternativa.
            elem.bind('keydown', function (e) { self.onKeyDownAlternatives(e); });

            //Definindo a propriedade "aria-label" para todos os elementos alternativa.
            $.each(this.alternatives["p" + i], function (index, alternative) {
                $(alternative).attr('aria-label', $(alternative).text());
            });

            this.currentAlter.splice(i, 1);
            i = i - 1;
        } else {
            respCerta.push(this.currentAlter[i]);
        }//else

    }//for
};

Likert.prototype.saveAnswer = function __saveAnswer() {

    //constroi objeto para ser salvo na api com as alternativas respondidas
    Control.saveQuestion(this.atividade)

}

Likert.prototype.loadAnswer = function __loadAnswer(objResposta) {

    var setResposta = objResposta[0].respostas;

    var checked, currResposta, self = this;

    setResposta.forEach(function(resp,index){

        currResposta = parseInt(resp.valor);
        checked = self.alternatives["p" + index].get(currResposta);

        self.onClickAlternatives(null,checked);
    })

    self.onClickBtnCheck(true);


}