import { messages } from './const/message.js';
import { apiRequest } from './fetchService/api.js';
import { fillInnerHtml } from './utils.js';

const params = new URLSearchParams(window.location.search);

if (params.has('verification-success')) {
  document.querySelector('.signupDiv').display = 'none';
  document.querySelector('#welcome-title').textContent = messages['VERIFICATION_SUCCESS'];
} else if (params.has('verification-failure')) {
  document.querySelector('#welcome-title').textContent = messages['VERIFICATION_FAILURE'];
}

const login = async () => {
  // const { email, password, messageSpan } = loginCredentials;
  // try{
  //   const response = await apiRequest('login')
  // }
  // catch {
  //   fillInnerHtml(messageSpan, messages['EXPIRED_TOKEN'], 'red');
  // }
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
    fillInnerHtml(messageSpan, messages[data['message']], 'green');
  } catch (err) {
    if (messages[err.details?.['error']]) {
      fillInnerHtml(messageSpan, messages[err.details['error']], 'red');
    }
    return;
  }
};

const loginCredentials = {
  email: document.querySelector('#loginForm .mail'),
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
