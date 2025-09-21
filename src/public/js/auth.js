import { messages } from './const/message.js';
import { regExpStore } from './const/regexpStore.js';
import { apiRequest } from './utils/api.js';

const login = () => {
  const { email, password, error } = loginCredentials;
  if (!regExpStore.mail.test(email.value) || !regExpStore.password.test(password.value)) {
    error.innerHTML = messages.AUTH_ERROR + ' ' + messages.TRY_AGAIN;
    return;
  } else {
    error.innerHTML = '';
  }
};

const signUp = async () => {
  const { email, password, errorSpan, username, confirmPassword } = signupCredentials;

  if (!regExpStore.mail.test(email.value)) {
    errorSpan.innerHTML = messages.EMAIL_INVALID;
    return;
  } else if (!regExpStore.username.test(username.value)) {
    errorSpan.innerHTML = messages.USERNAME_INVALID;
    return;
  } else if (!regExpStore.password.test(password.value)) {
    errorSpan.innerHTML = messages.PASSWORD_INVALID;
    return;
  } else if (password.value != confirmPassword.value) {
    errorSpan.innerHTML = messages.PASSWORD_MISMATCH;
    return;
  } else {
    errorSpan.innerHTML = '';
  }
  try {
    const userData = await apiRequest('signup', {
      method: 'POST',
      body: JSON.stringify({ email: email.value, username: username.value, password: password.value }),
    });
  } catch (err) {
    console.log(messages[err.details['error']]);
    if (messages[err.details['error']]) errorSpan.innerHTML = messages[err.details['error']];
    return;
  }

  console.log(userData);
};

const loginCredentials = {
  email: document.querySelector('#loginForm .mail'),
  password: document.querySelector('#loginForm .password'),
  submit: document.querySelector('#loginForm'),
  errorSpan: document.querySelector('#loginForm .error'),
};

const signupCredentials = {
  email: document.querySelector('#signupForm .mail'),
  username: document.querySelector('#signupForm .username'),
  password: document.querySelector('#signupForm .password'),
  confirmPassword: document.querySelector('#signupForm .confirmPassword'),
  submit: document.querySelector('#signupForm'),
  errorSpan: document.querySelector('#signupForm .error'),
};

loginCredentials.submit.addEventListener('submit', (e) => {
  e.preventDefault();
  login();
});

signupCredentials.submit.addEventListener('submit', (e) => {
  e.preventDefault();
  signUp();
});
