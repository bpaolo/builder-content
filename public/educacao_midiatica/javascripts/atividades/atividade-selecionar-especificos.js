/**
 * Created by rhenan.dinardi on 10/07/2018.
 */
function AtividadeSelectEspecifico(identificador, classQuestContainer, gabarito, feedAcerto, feedErro, config, elementos, feedAcertoParcial) {

    //Id do elemento que contem todas os selects da atividade.
    this.classQuestContainer = classQuestContainer;

    this.gabarito = gabarito;

    this.feedAcerto = feedAcerto || "Parabéns! você acertou todas as alternativas.";
    this.feedErro = feedErro || "Existe(m) uma(s) alternativa(s) incorreta(s)";
    this.feedAcertoParcial = feedAcertoParcial || "Atenção! Você não acertou todas as alternativas.";

    //variavel de configuração da atividade
    this.configAtv = config;

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

    //console.log(this.btnConferir, this.btnRefazer, this.btnLimpar, this.feedback, elementos);

    //conferindo se o usuário pode refazer atividade
    this.declareResetVariables(this);

}

AtividadeSelectEspecifico.prototype.declareResetVariables = function __declareResetVariables(_self) {

    this.qtdSelect = 0;

    //Objeto com todos os elementos que definidos como alternativas.
    this.alternatives = $('#' + this.classQuestContainer + ' .alternativa');

    this.countErros = 0;

    this.activityDone = false;

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

/**
 * Configurações iniciais da atividade.
 */
AtividadeSelectEspecifico.prototype.init = function __init() {

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

    this.btnLimpar.bind('click', function (e) {
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

    //if (this.configAtv.showBtnClear)
    //    this.btnLimpar.show();

    if (this.configAtv.showBtnConferir)
        this.btnConferir.show();

    this.btnLimpar.hide();

    this.setEvent();

};//init

/**
 * Adicionand evento nos elemento.
 */
AtividadeSelectEspecifico.prototype.setEvent = function __setEvent(e) {

    var self = this;

    //Apaga o texto de feedback e remove o atributo "role".
    this.feedback.text('').removeAttr('role', 'alert');

    this.btnRefazer.hide();

    if (this.configAtv.showBtnConferir) {
        this.btnConferir.show();
    }
    else{
        this.btnConferir.hide();
    }

    //Adicionando listeners de tecla em todas os elementos alternativa.
    this.alternatives.bind('keydown', function (e) { self.onKeyDownAlternatives(e); });

    //Adicionando listeners em todas os elementos alternativa.
    this.alternatives.on('click', function (e, index) {
        //e.preventDefault(); //há alternativas com link externo
        e.stopPropagation();

        self.onClickAlternatives(this);
    });


};//setEvent

AtividadeSelectEspecifico.prototype.onKeyDownAlternatives = function __onKeyDownAlternatives(e) {
    //impede a propagação do evento atual.
    e.stopPropagation();

    //Alternativa selecionada
    var $alternative = $(e.target);

    //Index da alternativa.
    var index = this.alternatives.index($alternative);

    //Alternativa anterior a questão selecionada.
    var prev_alter = this.alternatives[index - 1];

    //Alternativa posterior a questão selecionada.
    var next_alter = this.alternatives[index + 1];

    //Teclas ignoradas no código.
    if (e.altKey || e.shiftKey) return;

    switch (e.keyCode) {
        //Tecla espaço ou o enter de código 13...
        case this.keys.space:
        case this.keys.enter:

            //Não executa as seguintes instruções caso a tecla ctrl esteja pressionada.
            if (e.ctrlkey) return;

            //Executa o método responsável pelo comportamento de seleção de alternativa.
            this.onClickAlternatives(this);
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
            if( (index +1) < this.alternatives.length)
                next_alter.focus();
            break;
    }//switch
}
//onKeyDownAlternatives

AtividadeSelectEspecifico.prototype.onClickAlternatives = function __onClickAlternatives(_elem) {

    var Anwsered = 0;

    var self = this;

    if(!$(_elem).attr("disabled")) {

        if ($(_elem).attr("checked")) {

            $(_elem).attr("checked", null);
            $(_elem).attr("aria-checked", "false");
            $(_elem).removeClass("ativo");
        }
        else {

            $(_elem).attr("checked", "checked")
            $(_elem).addClass("ativo");
            $(_elem).attr("aria-checked", "true");
        }

        //verifica se possui algum check selecionado
        $.each(this.alternatives, function (index, alternative) {

            if ($(alternative).attr("checked")) Anwsered++;
        });

        if (Anwsered > 0) {

            this.btnConferir.show();
            this.btnLimpar.show();
        }
        else {
            this.btnConferir.hide();
            this.btnLimpar.hide();
        }
    }

}//onClickAlternatives

/**
 * Correção da atividade.
 */
AtividadeSelectEspecifico.prototype.onClickBtnCheck = function __onClickBtnCheck(_noSave) {

    $(this.feedback).attr('opacity', '0');

    var self = this;

    var totalCorrect = 0;
    var label = "";
    var notSelected = false;
    var listCorreto = [];

    this.saveData.gabaritos = [];

    $.each(this.alternatives, function (index, alternative) {

        $(alternative).removeClass('feedCerto feedErrado');

        //atualizando respostas do cursista para salvar
        self.saveData.gabaritos.push({"chave": (index+1), "valor": ($(alternative).attr("checked")) ? "1" : "0"});

        //verifica se a alternativa foi selecionada
        if($(alternative).attr("checked")) {

            //pega o seu valor
            var selected = $(alternative).data("option");

            if($.inArray( selected, self.gabarito ) > -1) {
                totalCorrect++;

                $(alternative).attr('disabled', 'disabled');
                $(alternative).addClass('certo');
                listCorreto.push($(alternative));

                $(alternative.childNodes).each(function (i, el) {
                    if (el.className && el.className.indexOf("textoFeedCerto") > -1)
                        $(el).show();
                });
            }
            else {

                $(alternative).addClass('feedErrado');
                self.countErros++;

                $(alternative.childNodes).each(function (i, el) {
                    if (el.className && el.className.indexOf("textoFeedErrado") > -1)
                        $(el).show();
                });
            }
        }
    });


    // //Se a resposta for certa ou errada, tanto a propriedade aria-label quanto o feedback serão atualizados com essa informação.
    if (totalCorrect == self.gabarito.length && self.countErros == 0) {

        label = this.feedAcerto;
        this.activityDone = true;

        listCorreto.forEach(function(item){
            item.addClass('feedCerto');
        })

        this.btnConferir.hide();

    } else if (totalCorrect == self.gabarito.length && self.countErros != 0){
        label = this.feedAcertoParcial;
    } else {
        label = this.feedErro;
    }//else

    //salvar resposta da questao
    if(!_noSave) this.saveAnswer();

    //Esconde o botão de corrigir e exibe o de refazer.
    this.btnConferir.hide();
    this.btnLimpar.hide();
    this.btnRefazer.show();
    this.alternatives.attr('disabled', 'disabled');

    this.activeFeed(label);

};//onClickBtnCheck


/**
 * refazer a atividade.
 */
AtividadeSelectEspecifico.prototype.onClickbtnRefazer = function __onClickbtnRefazer(e) {

    var self = this;

    if(this.activityDone) {
        this.redoActivity();
    }
    else{
        $.each(this.alternatives, function (index, alternative) {

            $(alternative).attr('disabled', false);

            //verifica se a alternativa foi selecionada
            if($(alternative).attr("checked")) {

                var selected = $(alternative).data("option");

                if(!$(alternative).hasClass('certo')) {

                    $(alternative).attr("checked", null);
                    $(alternative).attr("aria-checked", "false");
                    $(alternative).removeClass('certo feedCerto feedErrado ativo');

                    $(alternative.childNodes).each(function (i, el) {
                        if (el.className && el.className.indexOf("textoFeedErrado") > -1 )
                            $(el).hide();
                    });
                }
                else{
                    $(alternative).attr('disabled', 'disabled');
                }
            }
        });

        //Anula o objeto.
        this.countErros = 0;
    }

    this.btnConferir.show();
    this.btnRefazer.hide();
    this.btnLimpar.hide();
    this.feedback.text('').removeAttr('role', 'alert');

};//onClickbtnRefazer


/**
 * Reinicia a atividade.
 */
AtividadeSelectEspecifico.prototype.redoActivity = function __redoActivity(e) {

    $.each(this.alternatives, function (index, alternative) {

        var selected = $(alternative).data("option");

        $(alternative).attr("checked", null);
        $(alternative).attr("aria-checked", "false");
        $(alternative).attr('disabled', false);
        $(alternative).removeClass('certo feedCerto feedErrado ativo');

        $(alternative.childNodes).each(function (i, el) {
            if (el.className && el.className.indexOf("textoFeedCerto") > -1 || el.className && el.className.indexOf("textoFeedErrado") > -1)
                $(el).hide();
        });

    });

    //Anula o objeto.
    this.countErros = 0;
    this.activityDone = false;

    if (this.configAtv.showBtnConferir)
        this.btnConferir.show();
    else
        this.btnConferir.hide();

    this.btnLimpar.hide();

};//redoActivity


/**
 * Executa o feedback visual
 */
AtividadeSelectEspecifico.prototype.activeFeed = function __activeFeed(label) {

    if (this.configAtv.feedModal) {
        $(".title-popup").addClass("activeFeed");
        this.modalFeedBack(label);
    } else {
        /*this.feedback.text("");
         this.feedback.text(label);*/
        this.feedback.empty();
        this.feedback.append(label);
    }//else


    // Anima o alpha do texto de feedback
    this.feedback.animate({opacity: 1}, 1000);
    this.feedback.animate({opacity: 0}, 1000);
    this.feedback.animate({opacity: 1}, 1000);

    //Atualizando a propriedade "role" do elemento com o valor alert. Isso faz o leitor de tela focar no alerta.
    this.feedback.attr('role', '');
    this.feedback.attr('role', 'alert');
};

/**
 * Executa o feedback modal
 */
AtividadeSelectEspecifico.prototype.modalFeedBack = function __modalFeedBack(feed) {
    // remove todos os filhos do elemento text
    $(".text").children().remove();
    // add feed ao elemento text
    $(".text").append(feed);
    //comando que executa a chamada da pop-up
    Modal.launchWindow();
}//modalFeedBack


AtividadeSelectEspecifico.prototype.saveAnswer = function __saveAnswer() {

    //constroi objeto para ser salvo na api com as alternativas respondidas
    Control.saveQuestion(this.atividade)

}

AtividadeSelectEspecifico.prototype.loadAnswer = function __loadAnswer(objResposta) {

    var setResposta = objResposta[0].respostas;
    var self = this;

    setResposta.forEach(function(resp, index){

        var alt = self.alternatives.get(index);

        if(resp.valor == "1") self.onClickAlternatives(alt);
    })

    self.onClickBtnCheck(true);
    this.activityDone = true;
}