// src/components/RegisterForm.js

import React, { useState } from 'react';
import axios from 'axios';

const RegisterForm = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [roles, setRole] = useState('ROLE_USER'); 
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
    <form onSubmit={handleSubmit}>
      <input type="email" value={email} onChange={(e) => setEmail(e.target.value)} placeholder="Email" required />
      <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} placeholder="Mot de passe" required />
      <select value={roles} onChange={(e) => setRole(e.target.value)}>
        <option value="ROLE_PROFESSOR">Professeur</option>
        <option value="ROLE_STUDENT">Etudiant</option>
        <option value="ROLE_USER">Utilisateur</option>
      </select>
      <button type="submit">S'inscrire</button>
    </form>
  );
};

export default RegisterForm;
