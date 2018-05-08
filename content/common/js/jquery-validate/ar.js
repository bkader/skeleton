(function (factory) {
    if (typeof define === "function" && define.amd) {
        define(["jquery", "../jquery.validate"], factory);
    } else if (typeof module === "object" && module.exports) {
        module.exports = factory(require("jquery"));
    } else {
        factory(jQuery);
    }
}(function ($) {

    /*
     * Translated default messages for the jQuery validation plugin.
     * Locale: AR (Arabic; العربية)
     */
    $.extend($.validator.messages, {
        required: "هذا الحقل اجباري.",
        remote: "يرجى تصحيح هذا الحقل للمتابعة.",
        email: "يرجى إدخال عنوان موقع إلكتروني صحيح.",
        url: "يرجى إدخال عنوان موقع إلكتروني صحيح.",
        date: "يرجى إدخال تاريخ صحيح.",
        dateISO: "يرجى إدخال تاريخ صحيح (ISO).",
        number: "يرجى إدخال عدد صحيح.",
        digits: "يرجى إدخال أرقام فقط.",
        creditcard: "يرجى إدخال رقم بطاقة ائتمان صحيح.",
        equalTo: "يرجى إدخال نفس القيمة.",
        notEqualTo: "يرجى إدخال قيمة مختلفة، يجب ألا تكون القي متشابهة.",
        extension: "يرجى إدخال قيمة بامتداد صحيح.",
        maxlength: $.validator.format("يرجى إدخال {0} أحرف على الأكثر."),
        minlength: $.validator.format("يرجى إدخال {0} أحرف على الأقل."),
        rangelength: $.validator.format("يرجى إدخال قيمة تحتوي على ما بين {0} و {1} أحرف."),
        range: $.validator.format("يرجى إدخال قيمة بين {0} و {1}."),
        max: $.validator.format("يرجى إدخال قيمة أقل من أو تساوي {0}."),
        min: $.validator.format("يرجى إدخال قيمة أكبر من أو تساوي {0}."),
        step: $.validator.format("يرجى إدخال قيمة من مضاعفات {0}."),
        maxWords: $.validator.format("يرجى إدخال {0} كلمات على الأكثر."),
        minWords: $.validator.format("يرجى إدخال {0} كلمات على الأقل."),
        rangeWords: $.validator.format("يرجى إدخال ما بين {0} و {1} كلمات."),
        letterswithbasicpunc: "يرجى إدخال الحروف وعلامات الترقيم فقط.",
        alphanumeric: "يرجى إدخال حروف، أرقام، مسافات والشرطات السفلية فقط.",
        lettersonly: "يرجى إدخال حروف فقط.",
        nowhitespace: "يرجى عدم إدراج مساحات فارغة.",
        integer: "يرجى إدخال رقم غير عشري إيجابي أو سلبي.",
        vinUS: "يرجى إدخال رقم تعريف السيارة (VIN).",
        dateITA: "يرجى إدخال تاريخ صالح.",
        time: "يرجى إدخال وقت صالح بين الساعة 00:00 و 23:59.",
        phoneUS: "يرجى إدخال رقم هاتف صالح.",
        phoneUK: "يرجى إدخال رقم هاتف صالح.",
        mobileUK: "يرجى إدخال رقم هاتف محمول صحيح.",
        strippedminlength: $.validator.format("يرجى إدخال {0} أحرف على الأقل."),
        email2: "يرجى إدخال عنوان موقع إلكتروني صحيح",
        url2: "يرجى إدخال عنوان موقع إلكتروني صحيح.",
        creditcardtypes: "يرجى إدخال رقم بطاقة ائتمان صالحة.",
        ipv4: "يرجى إدخال عنوان IP v4 صالح.",
        ipv6: "يرجى إدخال عنوان IP v6 صالح.",
        require_from_group: "يرجى إدخال ما لا يقل عن {0} من هذه المجالات.",
        nifES: "يرجى إدخال رقم NIF صالح.",
        nieES: "يرجى إدخال رقم NIE صالح.",
        cifES: "يرجى إدخال رقم CIF صالح.",
        postalCodeCA: "يرجى إدخال رمز بريدي صالح."
    });
    return $;
}));
