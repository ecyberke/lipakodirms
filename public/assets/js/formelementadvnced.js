(function($) {
    "use strict";

    // SumoSelect - only init if elements exist
    if ($('.SlectBox').length) {
        window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3, selectAll: true, captionFormatAllSelected: "Yeah, OK, so everything." });
    }
    if ($('.search-box').length) {
        window.Search = $('.search-box').SumoSelect({ csvDispCount: 3, search: true, searchText: 'Enter here.' });
    }
    if ($('.SlectBox-grp-src').length) {
        window.sb = $('.SlectBox-grp-src').SumoSelect({ csvDispCount: 3, search: true, searchText: 'Enter here.', selectAll: true });
    }
    if ($('.testselect1').length) { $('.testselect1').SumoSelect(); }
    if ($('.testselect2').length) { $('.testselect2').SumoSelect(); }
    if ($('.select1').length) { $('.select1').SumoSelect({ okCancelInMulti: true, selectAll: true }); }
    if ($('.select3').length) { $('.select3').SumoSelect({ selectAll: true }); }
    if ($('.search_test').length) { $('.search_test').SumoSelect({ search: true, searchText: 'Enter here.' }); }

    // jQuery Transfer - only init if container exists
    if (document.getElementById('transfer')) {
        var languages = [
            { "language": "jQuery", "value": 122 },
            { "language": "AngularJS", "value": 132 },
            { "language": "ReactJS", "value": 422 },
            { "language": "VueJS", "value": 232 },
            { "language": "JavaScript", "value": 765 },
            { "language": "Java", "value": 876 },
            { "language": "Python", "value": 453 },
            { "language": "TypeScript", "value": 125 },
            { "language": "PHP", "value": 633 },
            { "language": "Ruby on Rails", "value": 832 }
        ];
        var groupData = [
            {
                "groupName": "JavaScript",
                "groupData": [
                    { "language": "jQuery", "value": 122 },
                    { "language": "AngularJS", "value": 643 },
                    { "language": "ReactJS", "value": 422 },
                    { "language": "VueJS", "value": 622 }
                ]
            },
            {
                "groupName": "Popular",
                "groupData": [
                    { "language": "JavaScript", "value": 132 },
                    { "language": "Java", "value": 112 },
                    { "language": "Python", "value": 124 },
                    { "language": "TypeScript", "value": 121 },
                    { "language": "PHP", "value": 432 },
                    { "language": "Ruby on Rails", "value": 421 }
                ]
            }
        ];
        var settings = {
            "inputId": "languageInput",
            "data": languages,
            "groupData": groupData,
            "itemName": "language",
            "groupItemName": "groupName",
            "groupListName": "groupData",
            "container": "transfer",
            "valueName": "value",
            "callable": function(data, names) {
                console.log("Selected ID: " + data);
                $("#selectedItemSpan").text(names);
            }
        };
        Transfer.transfer(settings);
    }

    // Multi select - only init if elements exist
    if (document.getElementById('fruit_select')) {
        multi(document.getElementById('fruit_select'), {
            non_selected_header: 'Fruits',
            selected_header: 'Favorite fruits'
        });
    }
    if (document.getElementById('fruit_select1')) {
        multi(document.getElementById('fruit_select1'), {
            enable_search: true
        });
    }

    // Fancy file upload - only init if element exists
    if ($('#demo').length) {
        $('#demo').FancyFileUpload({
            params: { action: 'fileuploader' },
            maxfilesize: 1000000
        });
    }

})(jQuery);
