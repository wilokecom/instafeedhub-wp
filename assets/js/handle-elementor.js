jQuery(document).ajaxComplete(function (event, xhr, settings) {
    let param, data, keys, vals, actions, action;
    if (!!settings.data) {
        param = new URLSearchParams(settings.data);
        actions = JSON.parse(param.get('actions'));
        if (!!actions) {
            keys = Object.keys(actions);
            vals = keys.map(function (item) {
                return actions[item];
            });
            if (!!vals[0].data && !!vals[0].data.data) {
                data = vals[0].data.data;
                //Add
                if (data.widgetType === 'instafeedhub') {
                    console.log('aaaaa');
                }
            }
        }
    }
});
