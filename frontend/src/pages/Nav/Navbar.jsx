import React, { useState } from 'react';
import { NavLink } from 'react-router-dom';

import logo from "../../assets/logo.svg";
import user_icon from "../../assets/user-information-290.svg";
import NavLinks from '../../components/Navbar/NavLinks';


const Navbar = () => {
  const [showMobileMenu, setShowMobileMenu] = useState(false);

  return (
    <nav className="w-full bg-dark_primary_first text-ligther_neutral">
      <div className="max-w-7xl mx-auto flex items-center justify-between h-16 px-4 border-b border-solid border-slate-600">
        <NavLink to={`/`} className="flex-shrink-0 font-bold tracking-wider">
          <img src={logo} className="h-8 mr-3" alt="Flowbite Logo" />
        </NavLink>

        <div className="hidden md:block items-center">
          <NavLinks />
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

