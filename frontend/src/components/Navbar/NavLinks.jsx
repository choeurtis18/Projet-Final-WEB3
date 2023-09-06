import { NavLink } from "react-router-dom";
import Cookies from 'js-cookie';


export default function NavLinks() {
  const jwt = Cookies.get('token');

    return (
      <div className="max-sm:flex-wrap max-sm:p-4 max-sm:gap-4 sm:space-x-2 max-sm:flex">
        <NavLink to={`/`} className="w-full">
            Accueil
        </NavLink>
        <NavLink to={`/masterclasses`} className="w-full">
            Masterclass
        </NavLink>
        {!jwt && (
            <NavLink to={`/login`} className="w-full">
                Se connecter
            </NavLink>
        )}

        {!jwt && (
            <NavLink to={`/register`} className="w-full">
                S'inscrire
            </NavLink>
        )}
      </div>
    );
};
