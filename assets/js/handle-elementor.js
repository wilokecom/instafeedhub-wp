// jQuery(document).ajaxComplete(function (event, xhr, settings) {
//     let param, data, keys, vals, actions, action;
//     if (!!settings.data) {
//         param = new URLSearchParams(settings.data);
//         actions = JSON.parse(param.get('actions'));
//         if (!!actions) {
//             keys = Object.keys(actions);
//             vals = keys.map(function (item) {
//                 return actions[item];
//             });
//
//             if (!!vals[0].data && !!vals[0].data.data) {
//                 data = vals[0].data.data;
//                 //Add
//                 if (data.widgetType === 'instagram-feedhub') {
//                     console.log(data);
//                 }
//             }
//         }
//     }
// });
//
// elementor.hooks.addAction( 'panel/open_editor/widget', function( panel, model, view ) {
//     console.log(panel);
// } );
// console.log(elementor)
jQuery(document).ready(function () {
    jQuery('body').on('focus', '.tooltip-target', function (event) {
        console.log(jQuery(event.target))
    });
    console.log(123)
});