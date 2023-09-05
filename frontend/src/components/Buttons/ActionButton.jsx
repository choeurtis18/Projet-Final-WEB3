import React from 'react';
import {NavLink} from "react-router-dom";

// Button component
const ActionButton = ({ text, onClick, nav_link }) => {
  return (
    <button onClick={onClick} className="bg-primary_first text-ligther_neutral font-bold py-2 px-6 rounded-md ml-4 hover:bg-mid_primary_first">
      <NavLink to={nav_link}>{text}</NavLink>
    </button>
  );
};

export default ActionButton;