import {useParams} from "react-router-dom";
import { useState, useEffect } from "react";
//import {NavLink} from "react-router-dom";

import useGetInstrument from "../../Hook/useGetInstrument";

const Instrument = () => {
    const {id} = useParams();
    const [instrument, setInstrument] = useState([]);
    const [masterclasses, setMasterclasses] = useState([]);

    const getInstrument = useGetInstrument();

    useEffect(() => {
        getInstrument(id).then(data => {
            setInstrument(data.instrument);
            setMasterclasses(data.masterclass);
        });
    }, []);


    return (
        <div className="w-full">
            <h1 className='text-3xl my-12 font-medium text-center text-primary_first font-black'>{instrument.name}</h1>

            <div className="flex flex-col my-4 lg:flex md:flex">
                <h2 className='text-2xl my-8 font-medium text-mid_primary_second font-black'>Les masterclasses</h2>
                <div className='flex flex-wrap gap-8 text-center'>
                {
                    masterclasses.map((masterclasse, index) => (
                        <div className="border border-mid_primary_second rounded-lg p-4 lg:w-1/3 bg-ligther_primary_second grid gap-y-2" key={index}>
                            <h3 className="text-xl font-black text-mid_primary_second font-black">{masterclasse.title}</h3>
                            <p>{masterclasse.description}</p>
                        </div>  
                    ))
                /*
                <NavLink key={index} to={`/masterclasse/${masterclasse.id}`}
                            className='text-black text-decoration-none w-100 d-block text-center 10'>
                    {masterclasse.name}
                </NavLink>
                */
                }
                </div>     
            </div>
        </div>
    );
};

export default Instrument;
