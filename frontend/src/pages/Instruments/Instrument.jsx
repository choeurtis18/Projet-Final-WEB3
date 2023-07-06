import {NavLink, useParams} from "react-router-dom";

import Get_Instrument from "../../components/Instrument/Instrument";
import OthersMasterclass from "../../components/Masterclass/OthersMasterclass";

const Instrument = () => {
    const {id} = useParams();

    return (
        <div className="w-full">
            <NavLink to={`/instruments`}
                        className="">
                Revoir la liste des instruments
            </NavLink>
            <Get_Instrument id={id} ></Get_Instrument>
            <OthersMasterclass id={id} type="instrument"></OthersMasterclass>
        </div>
    );
};

export default Instrument;
