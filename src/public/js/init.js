import { checkUser } from './fetchService/api.js';

const routine = async () => {
  const isLogged = await checkUser();
  if (isLogged) document.body.style.display = '';
};

routine();
