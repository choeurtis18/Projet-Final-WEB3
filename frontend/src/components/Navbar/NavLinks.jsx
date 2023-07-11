import { NavLink } from "react-router-dom";

export default function NavLinks() {
    return (
      <div className="max-sm:flex-wrap max-sm:p-4 max-sm:gap-4 sm:space-x-2 max-sm:flex">
        <NavLink to={`/`} className="w-full">
            Accueil
        </NavLink>
        <NavLink to={`/masterclasses`} className="w-full">
            Masterclass
        </NavLink>
      </div>
    );
};
