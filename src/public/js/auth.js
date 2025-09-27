import { NOT_CONNECTED, SUCCESS } from './const/const.js';
import { messages } from './const/message.js';
import { apiRequest, fetchMe } from './fetchService/api.js';
import { useSplashScreen } from './global/splashScreen.js';
import { fillInnerHtml } from './utils.js';


  const params = new URLSearchParams(window.location.search);


const login = async () => {
  const { userID, password, messageSpan } = loginCredentials;
  try {
    const data = await apiRequest('login', {
      method: 'POST',
      body: JSON.stringify({ id: userID.value, password: password.value }),
    });
    if (data[SUCCESS]) window.location.href = '/home';
  } catch (err) {
    if (messages[err.details?.['error']]) {
      fillInnerHtml(messageSpan, messages[err.details['error']], 'red');
    }
  }
};

const signUp = async () => {
  const { email, password, messageSpan, username, confirmPassword } = signupCredentials;
  if (password?.value != confirmPassword?.value) {
    fillInnerHtml(messageSpan, messages['PASSWORD_MISMATCH'], 'red');
    return;
  }

  try {
    console.log('before');
    const data = await apiRequest('signup', {
      method: 'POST',
      body: JSON.stringify({ email: email.value, username: username.value, password: password.value }),
    });
    fillInnerHtml(messageSpan, messages[data['message']] + ' ' + email.value, 'green');
  } catch (err) {
    if (messages[err.details?.['error']]) {
      fillInnerHtml(messageSpan, messages[err.details['error']], 'red');
    }
    return;
  }
};

const loginCredentials = {
  userID: document.querySelector('#loginForm .userId'),
  password: document.querySelector('#loginForm .password'),
  submit: document.querySelector('#loginForm'),
  messageSpan: document.querySelector('#loginForm .message'),
};
const signupCredentials = {
  email: document.querySelector('#signupForm .mail'),
  username: document.querySelector('#signupForm .username'),
  password: document.querySelector('#signupForm .password'),
  confirmPassword: document.querySelector('#signupForm .confirmPassword'),
  submit: document.querySelector('#signupForm'),
  messageSpan: document.querySelector('#signupForm .message'),
};

loginCredentials.submit?.addEventListener('submit', (e) => {
  e.preventDefault();
  login();
});

signupCredentials.submit?.addEventListener('submit', (e) => {
  e.preventDefault();
  signUp();
});

const query = Object.fromEntries(params.entries());
try {
  useSplashScreen();
  if (query?.[NOT_CONNECTED] == 'true') await fetchMe();
  window.location.href = '/home';
} catch {
  console.log(query)
}
