import React from 'react';
import {NavLink} from "react-router-dom";

// Button component
const RouteLink = ({ text, nav_link}) => {
  return (
      <p className="text-mid_primary_first mr-3 hover:text-primary_first">
        <NavLink to={nav_link}>{text}</NavLink>
      </p>
  );
};

export default RouteLink;