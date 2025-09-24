import { apiRequest } from "./fetchService/api.js";


const checkUserAndRedirect = async () => {
  try {
    const data = await apiRequest('me');
    if (data['authenticated'] == true) {
      window.location.href = '/home';
    }
  } catch (err) {
    window.location.href = '/login?not-connected';
  }
};

export const fetchMe = async () => {
  try {
    const data = await apiRequest('me');
    if (data['authenticated'] == true) {
      return data;
    }
  } catch (err) {
    console.log(err)
  }
};

// checkUserAndRedirect();
