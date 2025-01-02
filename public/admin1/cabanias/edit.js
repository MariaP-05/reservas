if (!cabanias) {
    var cabanias = {};
}

cabanias = {
    add_caracteristica: function () {
        $(".nueva_caracteristica")
            .last()
            .find(".id_caracteristica")
            .select2("destroy");

        var clone = $(".nueva_caracteristica").last().clone();

        clone.find("input:text").val("").end();
        clone.find(".cantidad").val("").end();
        clone.find(".id_caracteristica").end();
        clone.appendTo(".caracteristicas-section");

        $(".id_caracteristica").select2();
       
    },

    init: function () {
        $(".btn-add-caracteristica").on("click", this.add_caracteristica);
    },
};

$(function () {
    "use strict";
    cabanias.init();
});
