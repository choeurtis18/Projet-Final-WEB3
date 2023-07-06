import {useParams} from "react-router-dom";
import { useState, useEffect } from "react";
//import {NavLink} from "react-router-dom";

import useGetComposer from "../../Hook/useGetComposer";

function Composer ()  {
    const {id} = useParams();
    const [instruments, setInstruments] = useState([]);
    const [masterclasses, setMasterclasses] = useState([]);
    const [composer, setComposer] = useState([]);
    const getComposer = useGetComposer();

    useEffect(() => {
        getComposer(id).then(data => {
            setComposer(data.composer);
            setMasterclasses(data.composer.masterclasses);
            setInstruments(getUniqueInstrumentNames(data.composer.masterclasses));
        });
    }, []);

    function getUniqueInstrumentNames(masterclasses) {
        const instrumentNames = [];
        
        for (const key in masterclasses) {
            if (masterclasses.hasOwnProperty(key)) {
                const instrumentName = masterclasses[key].Instrument.name;
            
                if (!instrumentNames.includes(instrumentName)) {
                    instrumentNames.push(instrumentName);
                }
            }
        }
        
        return instrumentNames;
    }

    return (
        <div className="w-full">
            <h1 className='text-3xl my-12 text-primary_first font-black'>{composer.name}</h1>
            <div className="grid gap-x-16 my-4 lg:flex">
                <div className='w-auto lg:w-2/3'>
                    <h2 className="text-2xl font-bold text-mid_primary_first font-black">Description</h2>
                    <p className=''>{composer.description}</p>                
                </div>
                <div className='w-auto lg:w-1/3'>
                    <h2 className="text-2xl font-bold text-dark_primary_first font-black">Les instruments</h2>
                    <div className='flex flex-col'>
                    {
                        instruments.map((instrument, index) => (
                            <span key={index}>{instrument}</span>  
                        ))
                    }           
                    </div>     
                </div>
            </div>

            <div className="flex flex-col my-12 lg:flex md:flex">
                <h2 className='text-2xl my-2 font-medium text-mid_primary_second font-black'>Les masterclasses</h2>
                <div className='flex flex-wrap gap-8 text-center'>
                {
                    masterclasses.map((masterclasse, index) => (
                        <div className="border border-gray-200 rounded-lg p-4 lg:w-1/3 bg-ligther_primary_second grid gap-y-2" key={index}>
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

export default Composer;
