import { useSplashScreen } from '../global/splashScreen.js';

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

export const checkUser = async () => {
  useSplashScreen(2000);
  try {
    const data = await apiRequest('me');
    if (window.location.href == 'http://localhost:8080/') window.location.href = '/home';
    console.log(window.location.href);
    return true;
  } catch (err) {
    window.location.href = '/login?not-connected=true';
    return false;
  }
};

export const fetchMe = async () => {
  const data = await apiRequest('me');
  return data;
};
