import React, { useEffect, useState } from 'react';
import jwtDecode from 'jwt-decode';
import Cookies from 'js-cookie';

const GetUserIsAdmin = () => {
  const [userRole, setUserRole] = useState(null);

  useEffect(() => {
    const jwt = Cookies.get('token');

    if (jwt) {
      const decodedToken = jwtDecode(jwt);
      const userId = decodedToken.id;

      fetchUserRoleFromDatabase(userId, jwt)
        .then((role) => {
          setUserRole(role);
        })
        .catch((error) => {
          console.error('Erreur lors de la récupération du rôle :', error);
        });
    }
  }, []);

  const fetchUserRoleFromDatabase = async (userId, jwt) => {
    try {
      const response = await fetch(`http://localhost:8245/users/${userId}`, {
        headers: {
          Authorization: `Bearer ${jwt}`,
        },
      });

      if (!response.ok) {
        throw new Error('Erreur lors de la récupération du rôle');
      }

      const data = await response.json();

      const isAdmin = data.roles.includes("ROLE_ADMIN");

      return isAdmin; 
    } catch (error) {
      throw new Error(error);
    }
  };

  return userRole === true; 
  
};

export default GetUserIsAdmin;
