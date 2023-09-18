import { useState, useEffect } from "react";
import { NavLink } from "react-router-dom";

import useGetEventList from "../../Hook/useGetEventList";

const EventList = () => {
  const [eventList, setEventList] = useState([]);
  const getEventList = useGetEventList();

  useEffect(() => {
    getEventList().then(data => {
      console.log(data)
      setEventList(data.events);
    });
  }, [])

  return (
    <>
      <div className="flex flex-col my-4 lg:flex md:flex">
        <div className='lg:grid md:grid lg:grid-cols-3 md:grid-cols-2 flex flex-wrap gap-4'>
          {
            eventList.map((event, index) => (
              <div key={index} className="rounded-lg p-4 w-full shadow-shadow_2">
                <div className="flex flex-col">
                  <h3 className="text-xl text-mid_primary_first pb-2">{event.name}</h3>
                  <span className="text-mid_primary_second text-sm pb-2">Débute le {event.date_start}</span>
                </div>
                <p className="text-sm font-black text-mid_neutral pb-2">{event.description.substring(0, 100)}...</p>
                <NavLink to={`/event/${event.id}`}>
                  <p className="text-sm font-black text-right text-primary_first card-page-link">En Savoir plus</p>
                </NavLink>
              </div>
            ))
          }
        </div>     
      </div>
    </>
  );
};

export default EventList;
