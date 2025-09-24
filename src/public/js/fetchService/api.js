import { AUTHENTICATED } from "../const/const.js";

export async function apiRequest(endpoint, options = {}) {
  const response = await fetch(`/api/${endpoint}`, {
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    ...options,
  });

  const data = await response.json();
  if (!response.ok) {
    const err = new Error(`API error: ${response.status}`);
    err.details = data;
    throw err;
  }
  return data;
}

export const checkUserAndRedirect = async () => {
  try {
    const data = await apiRequest('me');
    if (data[AUTHENTICATED] == true) {
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
    // window.location.href = '/'
  }
};