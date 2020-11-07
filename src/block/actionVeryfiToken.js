import Axios from 'axios';
import handleError  from '../handleError';

const customAxios = Axios.create({ baseURL: 'https://instafeedhub.com/wp-json/instafeedhub/v1' });

const hanldePostAjaxAccesstockenToServer = (data = {}) => {
  // === ko su dung customAxios ...
  var bodyFormData = new FormData();
  bodyFormData.append({...data, action: 'instafeedhub_save_tokens'});
  Axios({
    method: 'POST',
    url: window.ajaxurl,
    data: bodyFormData,
    headers: {'Content-Type': 'multipart/form-data' }
  })
}

async function signin(whitelistedUrl, email, nickname, args) {
  try {
    const response = await customAxios.post('/wp-customer/signin ', {
      whitelistedUrl,
      email,
      nickname,
      args,
      variation: 'instafeedhub',
    });

    if (response.status === 200) {
      hanldePostAjaxAccesstockenToServer(response.data);
      return response.data;
    }else {
      return response.status  + ' - Some went error!'
    }
  } catch (error) {
    return handleError(error) || response.status + ' - Some went error!';
    }
}

async function verifyToken(data) {
  return ;
  try {
    const resVerifyToken = await customAxios.post('/verify-token', {
      ...data,
      variation: 'instafeedhub',
    });

    if (resVerifyToken.status === 200) {
      return;
    } else {
      return resVerifyToken.status + ' - Some went error!';
    }
  } catch (error) {
    if (error.responsive.status === 401) {
      // === renew token === //
      try {
        const resRenewToken = await customAxios.post('/renew-token', {
          refreshToken: data.refreshToken,
        });
        if (resRenewToken.status === 200) {
          await verifyToken({ ...data, accessToken: resRenewToken.data.accessToken });
          return;
        }else {
          return resRenewToken.status + ' Some went error!';
        }
      } catch (error) {
        return handleError(error) || resRenewToken.status + ' - Some went error!';
      }
      // === renew token === //
    }
    if (error.responsive.status === 409) {
      return handleError(error) || 'status: 409 - Error!';
    } 
    return handleError(error) ||  'Some went error!';
  }

  return;
}

export { verifyToken, signin };
