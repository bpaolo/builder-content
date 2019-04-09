/**
 * Created by rhenan.dinardi on 11/10/2018.
 */
var AvaAPI = (function(){

    'use strict';

    var avamec = this,
        api = new BridgeRestApi,

        //obj onde os metodos serao armazenados
        method = {},

        //lista dinamica dos metodos a serem criados
        methods = {
            obterDadosGenericos: { returnFn: "evObtemDadosGenericos"},
            obterDadosConclusaoUnidade: { returnFn: "evObtemDadosConclusaoUnidade"},
            obterDadosConclusaoCurso: { returnFn: "evObtemDadosDadosConclusaoCurso"},
            obterConfiguracaoConclusaoUnidade: { returnFn: "evObtemDadosConfiguracaoConclusaoUnidade"},
            obterStatusContraste: { returnFn: "evObtemStatusContraste"},
            obterConfiguracaoAtividade: { returnFn: "evObtemConfiguracaoAtividade"},
            obterRespostaAtividade: { returnFn: "evObtemDadosRespostaAtividade"},
            obterSeExisteProximaUnidade: { returnFn: "evObtemSeExisteProximaUnidade"},
            obterProximaUnidade: { returnFn: "evObtemProximaUnidade"},
            obterSeExisteUnidadeAnterior: { returnFn: "evObtemSeExisteUnidadeAnterior"},
            obterUnidadeAnterior: { returnFn: "evObtemUnidadeAnterior"},
            obterUnidade: { returnFn: "evObtemUnidade"},
            obterUltimaPaginaAcessada: { returnFn: "evObtemUltimaPaginaAcessada"},
            registrarDadosGenericos: {returnFn: "evObtemRegistraDadosGenericos"},
            registrarPorcentagemConclusaoUnidade: { returnFn: "evRegistraPorcentagemConclusaoUnidade"},
            registrarRespostaAtividade: { returnFn: "evRegistraRespostaAtividade"},
            registrarUltimaPaginaAcessada: { returnFn: "evObtemRegistraUltimaPaginaAcessada"},
            obterTamanhoFonte: { returnFn: "evObtemTamanhoFonte"},
            obterAncoraIrParaConteudo: { returnFn: "evObtemAncoraIrParaConteudo"},
            obterDadosCurso: { returnFn: "evObtemDadosCurso"}
    }

    /**
     * Contructor
     */

    /**
     Cria os metodos dinamicos, recebe até 2 parametros e um callback
     */
    function initialize(){

        $.each(methods,function(met, i){

            method[met] = function(_param1, _param2, _callback) {

                if(_callback) methods[met].callbackFn = _callback;

                api[met](_param1, _param2);
            }

            window.addEventListener(methods[met].returnFn ,function(event){

                methods[met].callbackFn && methods[met].callbackFn(event.detail);
            });

        });
    }

    /**
     Busca a Id do curso atual
     */
    function getUnitID () {
        return (/mod\d+\/uni\d+/.exec(document.location.pathname) || "ID_UNIT_DEFAULT").toString().replace(/\//g, "_")
    }

    /**
     Retorna a Id da atividade atual
     */
    function getActivityID () {
        return this.getUnitID() + "_ativ"
    }

    /**
     Verifica se o curso esta sendo acessado online
     */
    function isOnline () {
        return window.location !== window.parent.location
    }

    initialize();

    return {
        API: api,
        method: method,
        getUnitID: getUnitID,
        getActivityID: getActivityID,
        isOnline: isOnline
    }

})();
