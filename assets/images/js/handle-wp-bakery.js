jQuery(document).ajaxComplete(function (event, xhr, settings) {
  let data = settings.data;
  let param = new URLSearchParams(data);
  //Add
  if (param.get('action') === 'vc_edit_form' && param.get('tag') === 'vc-instagram-feedhub') {
    console.log({ data, settings });

    setTimeout(() => {
      const input = document.querySelector('input[name="vc-instagram-feedhub-input"]');
      const instaID = input.getAttribute('value');
      input.setAttribute('disabled', true);

      window.InstafeedHubTokens = { ...InstafeedHubTokens, args: { id: instaID } };

      // === postMessage to reactjs
      window.postMessage({ type: 'ADD_INSTA_BAKERY', payload: { instaID } }, location.origin);
    }, 1000);

    // === revice to reactjs
    window.addEventListener('message', event => {
      console.log(11, { event });
      if (event.data.type && event.data.type.includes('FE_INSTA_BACKERY_DATA')) {
        console.log(22, { event });
        input.setAttribute('value', event.data.payload.id);
      }
    });
  }
});
