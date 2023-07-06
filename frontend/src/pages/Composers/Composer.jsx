import {NavLink, useParams} from "react-router-dom";

import Get_Composer from "../../components/Composer/Composer";
import OthersMasterclass from "../../components/Masterclass/OthersMasterclass";

const Composer = () => {
    const {id} = useParams();

    return (
        <div className="w-full">
            <NavLink to={`/composers`}
                        className="">
                Revoir la liste des Compositeurs
            </NavLink>
            <Get_Composer id={id} ></Get_Composer>
            <OthersMasterclass id={id} type="composer"></OthersMasterclass>
        </div>
    );
};

export default Composer;
