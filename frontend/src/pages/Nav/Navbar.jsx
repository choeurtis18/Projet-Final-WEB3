import React, { useState, useEffect } from 'react';
import { NavLink } from 'react-router-dom';
import Cookies from 'js-cookie';
import { useHistory } from 'react-router-dom';
import logo from "../../assets/logo.svg";
import user_icon from "../../assets/user-information-290.svg";
import px from "../../assets/px.svg";
import xp from "../../assets/xp.svg";
import NavLinks from '../../components/Navbar/NavLinks';
import { RiLogoutBoxRLine } from 'react-icons/ri'; 

import useGetXpUser from "../../Hook/useGetXpUser";


const Navbar = () => {
  const [showMobileMenu, setShowMobileMenu] = useState(false);
  const [userXp, setUserXp] = useState(0);
  const [error, setError] = useState(null);
  const history = useHistory();

  const fetchUserXp = useGetXpUser();

  useEffect(() => {
    async function loadUserXp() {
      try {
        const data = await fetchUserXp();
        if (data && data.xp) {
            setUserXp(data.xp);
        }
      } catch (err) {
        setError(err.message);
      }
    }
    loadUserXp();
  }, [fetchUserXp]);

  console.log(userXp);

  const jwt = Cookies.get('token');
  const handleLogout = () => {
    Cookies.remove('token');

    history.push('/'); 
  }

  return (
    <nav className="w-full bg-dark_primary_first text-ligther_neutral">
      <div className="max-w-7xl mx-auto flex items-center justify-between h-16 px-4 border-b border-solid border-slate-600">
        <NavLink to={`/`} className="flex-shrink-0 font-bold tracking-wider cursor-pointer">
          <img src={logo} className="h-8 mr-3" alt="Flowbite Logo" />
        </NavLink>

        <div className="hidden md:block items-center">
          <NavLinks />
        </div>
        {!jwt && (
            <div className='flex row gap-5 md:w-64'>
            <NavLink to={`/login`} className="w-full">
                Se connecter
            </NavLink>
              <NavLink to={`/register`} className="w-full">
              S'inscrire
          </NavLink>
          </div>
        )}
        {jwt && (

        <div className='flex row gap-10'>
          
        <div>
            <img className="mr-2 inline" src={px} alt="px" />
            <span>{userXp}</span>
            <img className="mb-4 w-8 h-8 inline" src={xp} alt="xp count" />
          </div>
          <div>
                    <NavLink to={`/users/update`} className="flex-shrink-0 font-bold tracking-wider">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" className="w-6 h-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                      </svg>
                    </NavLink>
          
          </div>
          <div>
              <div>
                <button
                  onClick={handleLogout}
                  className="flex-shrink-0 font-bold tracking-wider text-2xl">
                  <RiLogoutBoxRLine /> 
                </button>
              </div>
          </div>
        </div>
  )}
        <button
          type="button"
          className="md:hidden bg-gray-900 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out"
          onClick={() => setShowMobileMenu(!showMobileMenu)}>
          <svg
            className="h-6 w-6"
            stroke="currentColor"
            fill="none"
            viewBox="0 0 24 24">
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth="2"
              d="M4 6h16M4 12h16M4 18h16"
            ></path>
          </svg>
        </button>
      </div>
      <div className="md:hidden">
        {showMobileMenu && <NavLinks />}
      </div>
    </nav>
  );
};

export default Navbar;

