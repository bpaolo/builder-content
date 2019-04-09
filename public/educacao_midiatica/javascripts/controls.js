/**
 * Created by rhenan.dinardi on 16/10/2018.
 */
var Control = (function main(){

    'use strict';

    var Navegacao = [],
        Settings = {},
        Telas = [],
        currUnitIndex = 0,
        currTelaIndex= 0,
        currTela = '',
        courseName = '',
        listActivities = [],
        loadedActivities = -1,
        atvAnswerControl = [];

    $(document).ready(function(){

        //eventos de progressso e navegaçao
        getConfig();

    });

    /**
     * Busca todos os carregamentos iniciais da tela
     */
    function getConfig() {

        //busca path do arquivo de navegação
        var indexPath = getPosition(location.pathname, '/', 2),
            path = location.pathname.substr(0, (-1 === indexPath ? 0 : indexPath));

        //Busca configuração das unidades
        $.getJSON('../../../configuracao_navegacao.json', function(response) {

            if (response)
            {
                Navegacao = response.navegacao;
                //seta indice igual a tela acessada
                getCurrentSlide(function(){

                    //armazena configuraçao de telas da unidade
                    Telas = Settings.telas;

                    //Botoes de navegacao
                    var btnNext = $(".btn-units-next"),
                        btnPrevious = $(".btn-units-prev");

                    AvaAPI.method.obterDadosConclusaoUnidade(Settings.identificador, null, function(ev){

                        //console.log("Status da Unidade ", ev);
                        var currProgress = (ev.status == 200) ? parseInt(ev.data.porcentagemConclusao) : 0;
                        setScreenUnitProgress(currProgress);
                    });

                    //----------------------SETAR NOME DO CURSO --------------------------------------------------
                    AvaAPI.method.obterDadosCurso(null, null, function(ev){

                        courseName = (ev.status == 200) ? ev.data.curso.nomeResumido : "";

                        if(ev.status == 200) {

                            courseName = ev.data.curso.nomeResumido;

                            //lista de modulos e unidades, construir menu lateral
                            var listModulos = ev.data.modulos;
                        }
                        else{
                            courseName = "";
                        }

                    });


                    btnPrevious.on('click touch', function () {

                        var path = getPreviousSlide();
                        if(path.length) window.location.href = path;
                    });

                    btnNext.on('click touch', function () {

                        var path = getNextSlide();
                        if(path.length) window.location.href = path;
                    });

                    //salvando ultimo acesso
                    saveLastAccessPage();

                    //verifica se a tela possui atividade
                    if(Telas[currTelaIndex].atividade != undefined) {

                        //Buscar lista de respostas de todas as atividades dessa tela
                        retrieveActivityData();
                    }
                    else{

                        //sem atividade, visao é nagevação, atualiza progresso de acordo com a tela
                        saveCurrentProgress();
                    }

                    //verifica se existe proxima unidade após ultima tela
                    if(currTelaIndex == Telas.length -1) {

                        AvaAPI.method.obterSeExisteProximaUnidade(Settings.identificador, null, function(ev){

                            //console.log("existe proxima unidade? ", ev);
                            //se existir, redireciona para proxima unidade
                            if(ev.data == true) {

                                btnNext.off('click touch').on('click touch', function () {

                                    AvaAPI.method.obterProximaUnidade(Settings.identificador);
                                });
                            }
                            else{
                                //btnNext.remove();
                            }
                        });
                    }

                    //verifica se existe unidade anterior a atual
                    AvaAPI.method.obterSeExisteUnidadeAnterior(Settings.identificador, null, function(ev) {

                        //console.log("existe unidade anterior? ", ev);
                        //se existir, redireciona para unidade anterior
                        if (ev.data == true) {

                            btnPrevious.off('click touch').on('click touch', function () {

                                AvaAPI.method.obterUnidadeAnterior(Settings.identificador);
                            });
                        }
                        else {
                            //btnPrevious.remove();
                        }
                    });


                });
            }
        });

    }

    /**
     * Registra % de progresso da unidade baseado no numero de telas
     */
    function saveCurrentProgress() {

        //calculo de tela atual para analisar progresso
        var progress = parseInt(((currTelaIndex+1) / Telas.length ) * 100 );

        //verificar antes se o progresso atual eh maior do que o atual
        AvaAPI.method.obterDadosGenericos('progresso_' + Settings.identificador, null, function(ev){

            //console.log('progresso total da ' + Settings.identificador, ev);
            var currProgress = (ev.status == 200) ? parseInt(ev.data[0].valor) : 0;

            //somente atualiza % de progresso caso o progresso seja maior que o atual
            if(currProgress < progress) {

                AvaAPI.method.registrarDadosGenericos('progresso_' + Settings.identificador, progress, function(ev){

                 //console.log("salvo progresso de " + Settings.identificador + " de " + progress + "% em genericos", ev);

                 });

                AvaAPI.method.registrarPorcentagemConclusaoUnidade(Settings.identificador, progress, function(ev){

                    //console.log("salvo progresso de " + Settings.identificador + " de " + progress + "% na unidade", ev);

                });

            }
        });

    }

    /**
     * Atualiza a barra de progresso do navbar com os progressos da unidade
     * @param _progress
     */
    function setScreenUnitProgress(_progress) {

        _progress = (_progress) ? _progress : 0;

        // PROGRESSO DA UNIDADE
        $(".progress-circle").attr('title', _progress + '%').tooltip();;
        $(".progress-circle__svg .progress-circle__fill").stop()
            .animate({'stroke-dashoffset': 53.407 - ((53.407 * 100 * _progress / 100) / 100) }, 1000)


    }

    /**
     * Salva tela atual como ultima tela acessada do curso
     */
    function saveLastAccessPage() {

        //registra tela como ultima acessada
        AvaAPI.method.registrarUltimaPaginaAcessada(Settings.identificador, Settings.caminho + '/' + currTela, function(ev){
            //console.log("salvo ultimo acesso da " + Settings.identificador, ev);
        });
    }

    /**
     * Encontra qual a tela atual em relaçao a lista de telas da unidade, seta o index
     */
    function getCurrentSlide(_callback) {

        var indexPath = location.pathname.lastIndexOf("/");
        var locationPath = location.pathname.substr(-1 === indexPath ? 0 : indexPath).replace("/", "");

        Navegacao.forEach(function(mod, index){

            mod.telas.forEach(function (unit, _index) {

                if( location.pathname.indexOf((mod.caminho + '/' + unit.tela)) !== -1) {

                    Settings = mod;
                    currUnitIndex = index;
                    currTelaIndex = _index;
                    currTela = unit.tela;
                }
            });

        });
        _callback && _callback();
    }

    /**
     * Retorna a url da proxima tela
     * @returns {string}
     */
    function getNextSlide() {

        var returnPath = '';

        //ultimo slide do modulo
        if (currTelaIndex + 1 >= Telas.length) {

        }
        else{

            var fixPathName =  window.location.pathname.replace( currTela, '' );
            returnPath = window.location.origin + fixPathName + Telas[currTelaIndex + 1].tela;
        }

        return returnPath;
    }

    /**
     * Retorna a url da unidade anterior
     * @returns {string}
     */
    function getPreviousSlide() {

        var returnPath = '';

        //primeiro slide do modulo
        if (currTelaIndex - 1 < 0) {

            var previousUnit = Navegacao[currUnitIndex-1];

            //verifica se possui unidades anterior a este (engessado pelo json?)
            if(previousUnit) {

                /*var fixPathName = window.location.pathname.replace(Settings.caminho + '/' + currTela, '');
                returnPath = window.location.origin + fixPathName + previousUnit.caminho + '/' + previousUnit.telas[previousUnit.telas.length -1].tela;*/

                //AvaAPI.method.obterUnidade(previousUnit.identificador);
            }
        }
        else{

            var fixPathName =  window.location.pathname.replace( currTela, '' );
            returnPath = window.location.origin + fixPathName + Telas[currTelaIndex - 1].tela;
        }

        return returnPath;
    }

    /**
     * Retorna para o index dos modulos
     * @returns {string}
     */
    function getHomePath() {
        var fixPathName =  window.location.pathname.replace( Settings.caminho + '/' + currTela, '' );

        return window.location.origin + fixPathName + 'index.html';
    }

    /**
     * Retorna posicao espcifica de uma string
     * @returns {string}
     */
    function getPosition (string, subString, index) {
        return string.split(subString, index).join(subString).length;
    }

    /**
     * -------------------------------------------- CONTROLE DE SALVAR E OBTER RESPOSTAS -------------------------------------------------
     * -----------------------------------------------------------------------------------------------------------------------------------
     */

    /**
     * Busca dados de uma atividade especifica e carrega suas respostas caso tenha respostas
     */
    function retrieveActivityData () {

        //Buscar lista de respostas de todas as atividades dessa tela
        loadedActivities++;

        if(loadedActivities < Telas[currTelaIndex].atividade.length) {

            var atvId = Telas[currTelaIndex].atividade[loadedActivities];

            //Verifica se o cursista possui respostas salvas para essa atividade
            AvaAPI.method.obterRespostaAtividade('' + atvId, null, function (ev) {

                //console.log("Possui respostas salvas de " + atvId + " ?", ev);


                /*ev = {status: 200,
                        data: {
                            questoesUsuario: [{
                                questao: {identificador: atvId},
                                respostas: [
                                    {id: 0, valor: "0", chave: "1"},
                                    {id: 1, valor: "1", chave: "2"},
                                    {id: 2, valor: "2", chave: "3"},
                                    {id: 3, valor: "3", chave: "4"},
                                    {id: 3, valor: "2", chave: "5"},
                                    {id: 3, valor: "1", chave: "6"},
                                    {id: 3, valor: "0", chave: "7"},
                                    {id: 3, valor: "1", chave: "8"},
                                    {id: 3, valor: "2", chave: "9"},
                                    {id: 3, valor: "3", chave: "10"},
                                ]
                            }]
                        }}*/

                var respondido = false;
                //se sim, carrega respostas no corpo das questoes
                if (ev.status == 200) {

                    respondido = true;

                    var objResposta = ev.data.questoesUsuario;

                    var currAtv = listActivities[loadedActivities];

                    currAtv.loadAnswer(objResposta);
                }

                //controle de questoes ja respondidas
                atvAnswerControl.push({id: atvId, respondida: respondido});

                //carrega proxima questao
                retrieveActivityData();
            });
        }
    }


    /**
     * Recebe um objeto de questao da atividade, e adiciona ao model que será salvo ao final da tela
     * @param _question (object: parametro com identificador de questao e gabarito)
     */
    function saveQuestion (atv){

        //console.log(atv);

        //se ha atividade para salvar respostas
        if(atv.identificador != '') {

            //console.log("Salvando respostas da ", atv.identificador);

            AvaAPI.method.registrarRespostaAtividade(atv, null, function(ev){

                //console.log("respostas registradas com sucesso ", ev);

                updateTotalAnswerQuestions(atv.identificador);
            })

        }
    }

    /**
     * Ao salvar uma questao, busca no control de total de questoes e atualiza se ela foi respondida ou nao,
     * para atualizar o progresso da tela
     */
    function updateTotalAnswerQuestions(_atvId) {

        //busca pela Id no controle a atividade realizada
        var updateAtv = atvAnswerControl.filter(function(atv){ return atv.id == _atvId })[0];

        updateAtv.respondida = true;

        //se todas foram respondidas atualiza progresso da tela
        var totalRespondido = atvAnswerControl.reduce(function(total, atv) {
            if (atv.respondida) {
                return total + 1;
            } else {
                return total;
            }
        }, 0);

        if(totalRespondido == Telas[currTelaIndex].atividade.length) saveCurrentProgress();


    }


    return {
        saveQuestion: saveQuestion,
        listActivities: listActivities
    }

    /**
     * Se voiceover para iOS
     */
    function setVoiceOverFocus(element)
    {
        var focusInterval = 10; // ms, time between function calls
        var focusTotalRepetitions = 10; // number of repetitions

        element.setAttribute('tabindex', '0');
        element.blur();

        var focusRepetitions = 0;
        var interval = window.setInterval(function ()
        {
            element.focus();
            focusRepetitions++;
            if (focusRepetitions >= focusTotalRepetitions)
                window.clearInterval(interval);
        }, focusInterval);
    }

})();
