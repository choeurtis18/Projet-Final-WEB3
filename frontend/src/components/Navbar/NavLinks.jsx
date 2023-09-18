import { NavLink } from "react-router-dom";
import Cookies from 'js-cookie';


export default function NavLinks() {
  const jwt = Cookies.get('token');

    return (
      <div className="max-sm:flex-wrap max-sm:p-4 max-sm:gap-4 sm:space-x-2 max-sm:flex">
        <NavLink to={`/`} className="pr-3 w-full">
            Accueil
        </NavLink>
        <NavLink to={`/masterclasses`} className="pr-3 w-full">
            Masterclass
        </NavLink>
        <NavLink to={`/formations`} className="pr-3 w-full">
            Formations
        </NavLink>
        <NavLink to={`/events`} className="pr-3 w-full">
            Événements
        </NavLink>
      </div>
    );
};
