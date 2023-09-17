// src/components/RegisterForm.js

import React, { useState } from 'react';
import axios from 'axios';
import { useHistory } from 'react-router-dom';


const RegisterForm = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [roles, setRole] = useState('user'); 
  const history = useHistory();

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const response = await axios.post('http://localhost:8245/register', {
        email: email,
        password: password,
        roles: [roles],
      });
      history.push('/login');
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-6">
      <div>
          <label className='block text-sm font-medium leading-6 text-gray-900'>Email</label>
          <div className='mt-1'>
            <input type="email" value={email} onChange={(e) => setEmail(e.target.value)} placeholder="Email" className='block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 input-form-login' required />
          </div>
      </div>
      <div>
          <label className='block text-sm font-medium leading-6 text-gray-900'>Mot de passe:</label>
          <div className='mt-1'>
            <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} placeholder="Mot de passe" className='block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 input-form-login' required />
          </div>
      </div>
      <div>
          <label className='block text-sm font-medium leading-6 text-gray-900'>Type d'utilisateur:</label>
          <div className='mt-1'>
            <select value={roles} onChange={(e) => setRole(e.target.value)} className="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6 input-form-login">
              <option value="professor">Professeur</option>
              <option value="student">Etudiant</option>
              <option value="user">Utilisateur</option>
            </select>
          </div>
      </div>
      <button type="submit" className='flex w-full justify-center rounded-md bg-secondary text-white px-3 py-1.5 text-sm font-semibold shadow-sm'>S'inscrire</button>
    </form>
  );
};

export default RegisterForm;
