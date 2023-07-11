import React, { useState } from 'react';
import {useDispatch, useSelector} from "react-redux";
import axios from 'axios';
import { useHistory } from 'react-router-dom';
import LoginReducer from '../../Reducer/LoginReducer';
import {types} from '../../constants/actionTypes';
import {LoginAction} from  '../../Actions/Login';


const Login = () => {
  const [user, setUser] = React.useState(null)
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [errorMessage, setErrorMessage] = useState('');

  const history = useHistory();

  const dispatch = useDispatch()
  

  const handleEmailChange = (event) => {
    setEmail(event.target.value);
  };

  const handlePasswordChange = (event) => {
    setPassword(event.target.value);
  };

  const handleLogin = async () => {

    dispatch({ type: types.LOGIN_REQUEST });

    try {
      const response = await axios.post('http://localhost:8245/login', {
        email,
        password,
      });

      const  token  = response.data.jwt;
      document.cookie = `token=${token}`
      

      dispatch(LoginAction(response.data.jwt, response.data.id, response.data.email, response.data.roles, types.LOGIN_SUCCESS ))
      history.push('/');

    } catch (error) {
      dispatch({ type: types.LOGIN_FAILURE, payload: error.response.data.message });
      setErrorMessage(error.response.data.message);
    }
  };

  return (
    <div>
      <h2>Login</h2>
      <div>
        <label>Email:</label>
        <input type="text" value={email} onChange={handleEmailChange} />
      </div>
      <div>
        <label>Password:</label>
        <input type="password" value={password} onChange={handlePasswordChange} />
      </div>
      <div>
        <button onClick={handleLogin}>Login</button>
      </div>
      {errorMessage && <div>{errorMessage}</div>}
    </div>
  );
};

export default Login;
