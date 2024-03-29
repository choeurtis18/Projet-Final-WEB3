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

      const token  = response.data.jwt;

      document.cookie = `token=${token}`
      
      history.push('/');
    } catch (error) {
      dispatch({ type: types.LOGIN_FAILURE});
      setErrorMessage(error.response.data.message);
    }
  };

  return (
    <div>
      <div className="space-y-6">
        <div>
          <label className='block text-sm font-medium leading-6 text-gray-900'>Email</label>
          <div className='mt-1'>
            <input type="text" value={email} onChange={handleEmailChange} placeholder="Entrez votre email (ex : john.doe@mail.com)" className='block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 input-form-login' />
          </div>
        </div>
        <div>
          <label className='block text-sm font-medium leading-6 text-gray-900'>Password</label>
          <div className='mt-1'>
            <input type="password" value={password} onChange={handlePasswordChange} placeholder="Entrez votre mot de passe (8 caractères minimum)"  className='block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 input-form-login' />
          </div>
        </div>
        <div>
          <button onClick={handleLogin} className='flex w-full justify-center rounded-md bg-secondary text-white px-3 py-1.5 text-sm font-semibold shadow-sm'>Se connecter</button>
        </div>
        {errorMessage && <div>{errorMessage}</div>}
      </div>
    </div>
  );
};

export default Login;
