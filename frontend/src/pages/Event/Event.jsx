import { useState, useEffect } from "react";
import {useParams, useHistory } from "react-router-dom";
import moment from "moment";
import GetUserIsAdmin from "../../components/User/GetUserIsAdmin";

import eventImage from "../../assets/event.jpg";

import ActionButton from "../../components/Buttons/ActionButton"
import RouteLink from "../../components/Route/RouteLink"

import useGetEvent from "../../Hook/useGetEvent";
import useDeleteEvent from "../../Hook/useDeleteEvent";

const Event = () => {
    const {id} = useParams();
    const [returnMessage, setReturnMessage] = useState('');
    const [event, setEvent] = useState([]);

    const deleteEvent = useDeleteEvent();
    const getEvent = useGetEvent();

    useEffect(() => {
        Promise.all([
            getEvent(id),
        ]).then(([event]) => {
            setEvent(event.event)
        })
    }, [id]);
    
    // Setting up the date's format
    let date_start = moment(event.date_start);
    let format_date_start = date_start.format("DD/MM/YYYY à  h:mm a")

    let date_end = moment(event.date_end);
    let format_date_end = date_end.format("DD/MM/YYYY à h:mm a")
   

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
        <div className="w-full p-12 ">
            <div className="flex items-center justify-start pb-8">
                <RouteLink text="Accueil" nav_link="/"></RouteLink>
                <svg className="mr-3 stroke-mid_primary_first" xmlns="http://www.w3.org/2000/svg" height="0.7em" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
                <RouteLink text="Evénements" nav_link="/events"></RouteLink>
                <svg className="mr-3 stroke-mid_primary_first" xmlns="http://www.w3.org/2000/svg" height="0.7em" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
                <RouteLink text={event.name} nav_link="#"></RouteLink>
            </div>
            {GetUserIsAdmin() && (
            <div className="my-6 flex flex-wrap items-center justify-end">
                <ActionButton text="Supprimer l'événement" onClick={handleDeleteEvent} nav_link="#"></ActionButton>
                <ActionButton text="Modifier" nav_link={`/update_event/${id}`}></ActionButton>
            </div>
            )}
            <span className=''>{returnMessage}</span>
            <div>
                <img src={eventImage} width="100%"/>
                <h1 className='text-3xl mt-6 mb-1 font-medium text-primary_first font-black'>{event.name}</h1>
                <div className="flex items-center mb-2">
                    <svg className="mr-1.5 " xmlns="http://www.w3.org/2000/svg" height="0.8em" viewBox="0 0 512 512"><path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>
                    <p className="text-sm">Du {format_date_start} au {format_date_end}</p>
                </div>
                <p>{event.description}</p>
            </div>
        </div>
    );
};

export default Event;
