import { useState } from "react";
import {NavLink, useParams, useHistory } from "react-router-dom";


import Get_Event from "../../components/Event/Event";
import useDeleteEvent from "../../Hook/useDeleteEvent";

const Event = () => {
    const {id} = useParams();
    const [returnMessage, setReturnMessage] = useState('');

    const deleteEvent = useDeleteEvent();
    

    const history = useHistory();
    const handleDeleteEvent = (e) => {
        deleteEvent(id).then(data => {
            setReturnMessage(data.message);

            if(data.message == "Event Delete") {
                history.push('/events', { replace: true });
            }
        });
    }
    

    return (
        <div className="w-full px-4 lg:px-16 md:px-16">
            <NavLink to={`/events`}
                        className="">
                Revoir la liste des événements
            </NavLink>
            <div className="grid gap-x-16 my-4 lg:flex md:flex">
                <div className='w-auto lg:w-1/2 md:w-1/2'>
                    <p className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded"
                      onClick={handleDeleteEvent}>Supprimer l'événement</p>
                </div>
                <div className='w-auto lg:w-1/2 md:w-1/2'> 
                <NavLink to={`/update_event/${id}`}
                    className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded">Update
                </NavLink>
                </div>
            </div>
            <span className=''>{returnMessage}</span>
            <Get_Event id={id} ></Get_Event>
        </div>
    );
};

export default Event;
