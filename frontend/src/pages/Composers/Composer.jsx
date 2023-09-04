import { useState } from "react";
import {NavLink, useParams, useHistory} from "react-router-dom";

import Get_Composer from "../../components/Composer/Composer";
import OthersMasterclass from "../../components/Masterclass/OthersMasterclass";
import useDeleteComposer from "../../Hook/useDeleteComposer";

const Composer = () => {
    const {id} = useParams();
    const [returnMessage, setReturnMessage] = useState('');

    const deleteComposer = useDeleteComposer();
    

    const history = useHistory();
    const handleDeleteComposer = (e) => {
        deleteComposer(id).then(data => {
            setReturnMessage(data.message);

            if(data.message == "Composer Delete") {
                history.push('/composers', { replace: true });
            }
        });
    }
    

    return (
        <div className="w-full px-4 lg:px-16 md:px-16">
            <NavLink to={`/composers`}
                        className="">
                Revoir la liste des Compositeurs
            </NavLink>
            <div className="grid gap-x-16 my-4 lg:flex md:flex">
                <div className='w-auto lg:w-1/2 md:w-1/2'>
                    <p className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded"
                        onClick={handleDeleteComposer}
                    >
                        Delete
                    </p>
                </div>
                <div className='w-auto lg:w-1/2 md:w-1/2'> 
                <NavLink to={`/update_composer/${id}`}
                    className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded">
                    Update
                </NavLink>
                </div>
            </div>
            <span className=''>{returnMessage}</span>
            <Get_Composer id={id} ></Get_Composer>
            <OthersMasterclass id={id} type="composer"></OthersMasterclass>
        </div>
    );
};

export default Composer;
