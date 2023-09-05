import React, { useState, useEffect } from 'react';
import { NavLink } from 'react-router-dom';

import logo from "../../assets/logo.svg";
import user_icon from "../../assets/user-information-290.svg";
import xp from "../../assets/xp.svg";
import NavLinks from '../../components/Navbar/NavLinks';
import useGetXpUser from "../../Hook/useGetXpUser";


const Navbar = () => {
  const [showMobileMenu, setShowMobileMenu] = useState(false);
  const [userXp, setUserXp] = useState(0);
  const [error, setError] = useState(null);
  
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

  return (
    <nav className="w-full bg-dark_primary_first text-ligther_neutral">
      <div className="max-w-7xl mx-auto flex items-center justify-between h-16 px-4 border-b border-solid border-slate-600">
        <NavLink to={`/`} className="flex-shrink-0 font-bold tracking-wider">
          <img src={logo} className="h-8 mr-3" alt="Flowbite Logo" />
        </NavLink>

        <div className="hidden md:block items-center">
          <NavLinks />
        </div>

        <div>
          <img className="w-8 h-8 inline" src={xp} alt="xp count" />
          <span>{userXp}</span>
        </div>

        <img className="w-8 h-8 rounded-full" src={user_icon} alt="user photo" />

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

