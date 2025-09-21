export const regExpStore = {
  mail: /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/,
  username: /^[A-Za-z0-9](?:[A-Za-z0-9_]{1,20}[A-Za-z0-9])$/,
  password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s])(?!.*\s).{8,72}$/,
};
