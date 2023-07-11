const initialState = {
    jwt: null,
    id: null,
    email: '',
    roles: [],
    isLoggedIn: false
};
  
export default function LoginReducer(state = initialState, action) {
    switch (action.type) {
      case 'LOGIN_SUCCESS':
        return {
          ...state,
          jwt: action.jwt,
          id: action.id,
          email: action.email,
          roles: action.roles,
          isLoggedIn: true
        };
      case 'LOGOUT':
        return {
          ...state,
          jwt: null,
          id: null,
          email: '',
          roles: [],
          isLoggedIn: false
        };
      default:
        return state;
    }
  }
  