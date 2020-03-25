export function isAuthenticated(token) {
  if (token) {
    return true;
  } else {
    return false;
  }
}

export const AuthHelper = {
  methods: {
    isAuthenticated
  }
};
