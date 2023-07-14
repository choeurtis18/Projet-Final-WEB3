const initialState = {
    jwt: null,
    id: null,
    isLoggedIn: false
};
  
export default function LoginReducer(state = initialState, action) {
    switch (action.type) {
      case 'LOGIN_SUCCESS':
        return {
          ...state,
          jwt: action.jwt,
          id: action.id,
          isLoggedIn: true
        };
      case 'LOGOUT':
        return {
          ...state,
          jwt: null,
          id: null,
          isLoggedIn: false
        };
      default:
        return state;
    }
  }
  