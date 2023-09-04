import { useState, useEffect } from "react";

import useGetEvent from "../../Hook/useGetEvent";

export default function Event(props) {
    const [event, setEvent] = useState([]);

    const getEvent = useGetEvent();

    useEffect(() => {
        getEvent(props.id).then(data => {
            setEvent(data.event);
        });
    }, []);


    return (
        <h1 className='text-3xl my-12 font-medium text-center text-primary_first font-black'>{event.name}</h1>
    );
};
