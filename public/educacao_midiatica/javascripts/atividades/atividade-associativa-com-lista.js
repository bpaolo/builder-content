
/**
 * Método construtor.
 * @param containerClass = Classe de identificação de todos os elementos que contem questões.
 * @param feedAcerto = Feedback de acerto.
 * @param feedErro = Feedback de erro.
 */
function AssociativaComLista( identificador, containerClass, feedAcerto, feedErro, config, elementos ){

    var self = this;

    //Armazenando pâramentros.
    this.containerClass = "#" + containerClass + " .alternativaQuiz .escolha";
    this.feedAcerto = feedAcerto || "Certo.";
    this.feedErro = feedErro || "Erro.";
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

    this.countErros = 0;

    //Controle do botão conferir.
    this.btnConferir = (elementos.btnConferir) ? $("#" + elementos.btnConferir) : $('#btnConferir');
    this.btnConferir.bind( {
        'click':function (e) { self.checkActivity(); },
        'keydown':function(e){ if( e.keyCode == 13 || e.keyCode == 32) self.checkActivity(); }
    });

    //Controle do botão refazer.
    this.btnRefazer = (elementos.btnRefazer) ? $("#" + elementos.btnRefazer) : $('#btnRefazer');
    this.btnRefazer.bind( {
        'click':function (e) { self.refazer(); },
        'keydown':function(e){ if( e.keyCode == 13 || e.keyCode == 32) self.refazer();  }
    });

    this.feedback = (elementos.feed) ? $("#" + elementos.feed) : null;

    //Status dos campos.
    this.STATUS_NAO_RESPONDIDO = "Não respondido.";
    this.STATUS_RESPONDIDO = "Respondido. Opção selecionada : ";
    this.STATUS_ERRADO = "Resposta errada! Opção selecionada : ";
    this.STATUS_CERTO = "Certa resposta! Opção selecionada : ";

    //Atribui descrição de não respondido em todos os campos.
    $(this.containerClass+' .status').text( this.STATUS_NAO_RESPONDIDO );

    //Estilizando o foco nos elementos selecionaveis.
    var _styleOutline = "#A4C6FD 2px solid";

    var elementosFocaveis = $( "#" + containerClass + " [tabindex]" ).filter( function(){ return this.tabIndex > 0; } );
    elementosFocaveis.on('focus', function(e){ e.currentTarget.style.outline = _styleOutline; });
    elementosFocaveis.on('focusout', function(e){ e.currentTarget.style.outline = ""; });

    //Controle da popup de feedback.
    this.maskPopup = $('.mask-popup');
    this.closePopup = $('.close-popup');
    this.maskPopup.bind( 'click', function( e ){ e.preventDefault(); self.fecharPopup(e); } );
    this.closePopup.bind( 'click', function( e ){ e.preventDefault(); self.fecharPopup(e); } );
    this.maskPopup.bind( 'keydown', function( e ){ e.preventDefault(); if( e.keyCode == 13 || e.keyCode == 32)  self.fecharPopup(e); } );
    this.closePopup.bind( 'keydown', function( e ){ e.preventDefault(); if( e.keyCode == 13 || e.keyCode == 32)  self.fecharPopup(e); } );
    this.conteudoPopup = $("#ConteudoPopup");
    this.conteudoPopup.hide();

    //Controle de alternativas.
    this.alternativas = $( this.containerClass + " select");

    this.alternativas.on("click", function(e){ self.selecionarCampo(e); });
    this.alternativas.on("keydown", function(e){ if( e.keyCode == 13 || e.keyCode == 32) self.selecionarCampo(e); } )

    //Controle de selects
    $(this.containerClass+' select').change( function(e){ self.selecionarOpcao( this ) } )

};


AssociativaComLista.prototype.selecionarCampo = function( e ) {
    e.stopPropagation();
    var lista = $(e.currentTarget).find('select').focus();
};


AssociativaComLista.prototype.selecionarOpcao = function( _select ){

    //Variáveis para definição da resposta do usuário e status da questão.
    var userAnswer = _select.selectedIndex;
    var indexSelected = $(_select).parent().data("option");
    var answer = $(_select).attr("answer");
    var result = userAnswer == answer ? "1" : "0";
    var container = $(_select).closest(this.containerClass);
    var status =  $(this.containerClass).find('#status_' + indexSelected);
    var campo = container.find('.campo');

    //Atualizando a resposta do usuário e o resultado da resposta.
    $(_select).attr("userAnswer", ""+_select.selectedIndex  );
    $(_select).attr("result", result);

    //Atualizando a descrição da questão para acessibilidade.
    if( _select.selectedIndex != 0  ) status.text(this.STATUS_RESPONDIDO+_select.value );
    else status.text(this.STATUS_NAO_RESPONDIDO);

    //Devolvendo o foco para o campo relacionado ao select.
    campo.focus();
};

AssociativaComLista.prototype.checkActivity = function(_noSave) {
    //Referencia do objeto.
    var allSelected = true;
    //Seleciona apenas as questões ativas na atividade.
    var questoesAtivas = $( this.containerClass ).filter( function () { return !$(this).attr("disabled"); });

    //Percorre cada questão ativa para corrigilas e definir suas configurações.
    $( questoesAtivas ).each( function () {

        //Elementos manipulados de cada questões.
        var status = $(this).find('.status');
        var select = $(this).find('select ');
        var campo = $(this).find('.campo');

        if( select.attr("userAnswer") == "0" ){
            allSelected = false;
            return false;
        }

    });
    if(allSelected) {
        this.conferir(_noSave);
    }else{

        this.feedback.empty();
        this.feedback.append("Você ainda não realizou todo o exercício.");

        // Anima o alpha do texto de feedback
        this.feedback.animate({opacity: 1}, 1000);
        this.feedback.animate({opacity: 0}, 1000);
        this.feedback.animate({opacity: 1}, 1000);

        //Atualizando a propriedade "role" do elemento com o valor alert. Isso faz o leitor de tela focar no alerta.
        this.feedback.attr('role', 'alert');

        /*this.conteudoPopup.html( "Você ainda não realizou todo o exercício." );
        var self = this;
        self.conteudoPopup.show();
        setTimeout(function(){
            self.conteudoPopup.hide();
        },6000);

        //Exibe o popup de feedback.
        this.closePopup.focus();
        try {
            Modal.launchWindow();
        }catch(e){}*/
    }
};

AssociativaComLista.prototype.conferir = function(_noSave) {

    //Flags de controle
    var terminou = true;
    var emBranco = false;

    //Referencia do objeto.
    var self = this;

    this.saveData.gabaritos = [];

    var questoes = $(this.containerClass+ " select");

    $( questoes ).each( function (index) {

        self.saveData.gabaritos.push({"chave": (index+1), "valor":  $(this).attr("userAnswer")});
    });

    //Seleciona apenas as questões ativas na atividade.
    var questoesAtivas = $( this.containerClass ).filter( function () { return !$(this).attr("disabled"); });

    //Percorre cada questão ativa para corrigi-las e definir suas configurações.
    $( questoesAtivas ).each( function () {

        //Elementos manipulados de cada questões.
        var select = $(this).find('select ');
        var selectedIndex = select.parent().data("option");
        var status = $(self.containerClass).find('#status_' + selectedIndex);
        var campo = $(this).find('.campo');

        //Se a resposta estiver certa.
        if( select.attr("result") == "1" ){
            campo.attr("disbabled", true).removeClass('wrong');
            select.attr("disabled", true ).removeClass('wrong');

            if(self.configAtv.showAnswer) {
                campo.addClass('correct');
                select.addClass("correct");
            }

            $(this).attr("disabled", true );
            status.text( self.STATUS_CERTO + select[0].value );
        }
        else{

            //Se a resposta estiver errada.
            if( select.attr("userAnswer") != "0" ){

                if(self.configAtv.showAnswer) {
                    campo.addClass('wrong');
                    select.addClass("wrong");
                }

                status.text(self.STATUS_ERRADO + select[0].value );
                self.countErros++;
            }
            else{
                //Se o usuário não selecionou uma opção válida
                campo.removeClass("wrong");
                select.removeClass("wrong");
                emBranco = true;
                status.text(self.STATUS_NAO_RESPONDIDO);
            }

            terminou = false;
        }
    });

    //Trecho adicionado apra atender a solicitação de que o botão refazer limpasse apenas as alternativas erradas,
    //portanto se o usuário tem algum erro o botão tem de ser mostrado.
    if(self.countErros > 0) {
        this.btnRefazer.show().attr("tabindex", tabindexBtnConferir);
        this.btnConferir.hide().attr("tabindex", tabindexBtnRefazer);
    }
    //Trecho adicionado apra atender a solicitação de que o botão refazer limpasse apenas as alternativas erradas,
    //portanto se o usuário tem algum erro o botão tem de ser mostrado.

    var label = '';

    //Se respodeu e acertou todas as questões.
    if( terminou ){

        label = this.feedAcerto;

        //Habilitando o botão de refazer.
        var tabindexBtnRefazer = this.btnRefazer.attr("tabindex");
        var tabindexBtnConferir = this.btnConferir.attr("tabindex");
        this.btnRefazer.show().attr("tabindex", tabindexBtnConferir);
        this.btnConferir.hide().attr("tabindex", tabindexBtnRefazer);

    }else{

        //
        if( emBranco ) label = "Você ainda não realizou todo o exercício." ;

        //
        else label = this.feedErro ;

    }


    if(!_noSave) this.saveAnswer();

    //Definindo feedback de acerto para a popup.
    this.feedback.empty();
    this.feedback.append(label);

    // Anima o alpha do texto de feedback
    this.feedback.animate({opacity: 1}, 1000);
    this.feedback.animate({opacity: 0}, 1000);
    this.feedback.animate({opacity: 1}, 1000);

    //Atualizando a propriedade "role" do elemento com o valor alert. Isso faz o leitor de tela focar no alerta.
    this.feedback.attr('role', '');
    this.feedback.attr('role', 'alert');


    /*self.conteudoPopup.show();
    setTimeout(function(){
        self.conteudoPopup.hide();
    },6000);

    //Exibe o popup de feedback.
    this.closePopup.focus();
    try {
        Modal.launchWindow();
    }catch(e){}*/

};



//codigo retirado de
//https://gitlab.mstech.com.br/prodesp/ec-comunicacao-curso/blob/develop/src/js/atividades/atividade-associativa-com-lista.js
AssociativaComLista.prototype.refazer = function(e) {

    var self = this;

    //Habilitando mecânica de conferir.
    var tabindexBtnRefazer = this.btnRefazer.attr("tabindex");
    var tabindexBtnConferir = this.btnConferir.attr("tabindex");
    this.btnRefazer.hide().attr("tabindex", tabindexBtnConferir);
    this.btnConferir.show().attr("tabindex", tabindexBtnRefazer);

    var questoes = $( this.containerClass + " select.wrong");

    this.feedback.empty().hide().attr("role","");

    if(questoes.length > 0) {
        questoes.removeClass('wrong').prop('selectedIndex', 0);

        questoes.each(function () {

            var indexSelected = $(this).parent().data("option");
            var status =  $(self.containerClass).find('#status_' + indexSelected);

            status.text(self.STATUS_NAO_RESPONDIDO);
        });

        return false;
    }
    else {
        $(this.containerClass).each(function () {

            var select = $(this).find('select');
            var campo = $(this).find('.campo');
            var status = $(this).find('.status');

            select.removeClass('wrong correct').attr({
                "userAnswer": "0",
                "result": "0",
                "disabled": false
            })[0].selectedIndex = 0;
            campo.removeClass('wrong correct').attr("disabled", false);
            status.text(self.STATUS_NAO_RESPONDIDO);
            $(this).attr("disabled", false);
        });
    }


};


AssociativaComLista.prototype.fecharPopup = function(e){

    //Seleciona uma questão ativa na atividade.
    var questaoAtiva = $( this.containerClass ).filter( function () { return !$(this).attr("disabled"); }).first();

    //Após o fechamento da popup verifica em qual elemento da pagina recebera foco.
    //Se a atividade não foi finalizada atribui o foco no primeiro elemento ativo.
    if( questaoAtiva ) Modal.closeWindow(e, questaoAtiva.find(".campo") );

    //Se atividade foi finalizada o foco vai para o botão refazer.
    else try{Modal.closeWindow( e, this.btnRefazer );}catch(e){}
};

AssociativaComLista.prototype.saveAnswer = function __saveAnswer() {

    //constroi objeto para ser salvo na api com as alternativas respondidas
    Control.saveQuestion(this.atividade)

}

/**
 * Recebe respostas da API e seta o exericio com a resposta da ultima alternativa
 */
AssociativaComLista.prototype.loadAnswer = function __loadAnswer(objResposta) {

    var setRespostas = objResposta[0].respostas;

    console.log("resposta ", setRespostas);

    var self = this;

    //$(this.containerClass+' select').change( function(e){ self.selecionarOpcao( this ) } )

    $.each( $(this.containerClass+' select'), function(index, elm) {

        //$(elm).eq(setRespostas[index].valor).prop('selected', true);
        $(elm).find('option')[parseInt(setRespostas[index].valor)].selected = true;

        $(elm).change();

        self.checkActivity(true);


    })

    var self = this;

}