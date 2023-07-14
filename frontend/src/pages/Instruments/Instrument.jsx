import { useState } from "react";
import {NavLink, useParams, useHistory } from "react-router-dom";


import Get_Instrument from "../../components/Instrument/Instrument";
import OthersMasterclass from "../../components/Masterclass/OthersMasterclass";
import useDeleteInstrument from "../../Hook/useDeleteInstrument";

const Instrument = () => {
    const {id} = useParams();
    const [returnMessage, setReturnMessage] = useState('');

    const deleteInstrument = useDeleteInstrument();
    

    const history = useHistory();
    const handleDeleteInstrument = (e) => {
        deleteInstrument(id).then(data => {
            setReturnMessage(data.message);

            if(data.message == "Instrument Delete") {
                history.push('/instruments', { replace: true });
            }
        });
    }
    

    return (
        <div className="w-full px-4 lg:px-16 md:px-16">
            <NavLink to={`/instruments`}
                        className="">
                Revoir la liste des instruments
            </NavLink>
            <div className="grid gap-x-16 my-4 lg:flex md:flex">
                <div className='w-auto lg:w-1/2 md:w-1/2'>
                    <p className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded"
                        onClick={handleDeleteInstrument}
                    >
                        Delete
                    </p>
                </div>
                <div className='w-auto lg:w-1/2 md:w-1/2'> 
                <NavLink to={`/update_instrument/${id}`}
                    className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded">
                    Update
                </NavLink>
                </div>
            </div>
            <span className=''>{returnMessage}</span>
            <Get_Instrument id={id} ></Get_Instrument>
            <OthersMasterclass id={id} type="instrument"></OthersMasterclass>
        </div>
    );
};

export default Instrument;
