import { useState, useEffect } from "react";
//import {NavLink} from "react-router-dom";

import useGetInstrument from "../../Hook/useGetInstrument";
import useAddInstrument from "../../Hook/useAddInstrument";

const Instrument = ({ questions }) => {
    const [instrument, setInstrument] = useState([]);
    const getInstrument = useGetInstrument();

    useEffect(() => {
        getInstrument().then(data => {
            setInstrument(data.instrument);
        });
    }, []);


    const [returnMessage, setReturnMessage] = useState('');
    const [instrumentName, setInstrumentName] = useState('');
    const addInstrument = useAddInstrument();
    
    const handleChangeName = (e) => {
        setInstrumentName(e.target.value);
    }

    const handleSubmit = (e) => {
        addInstrument(instrumentName, instrumentDescription).then(data => {
            setReturnMessage(data.messages);
        });
    }

    return (
        <div>
            <h1 className='m-5 text-center'>{instrument.name}</h1>

            <h2 className='m-5 text-center'>Les masterclasses</h2>
            { /*
                instrument.masterclasses.map((masterclasse, index) => (
                    <span key={index}>{masterclasse.name}</span>    
                    <NavLink key={index} to={`/masterclasse/${masterclasse.id}`}
                                className='text-black text-decoration-none w-100 d-block text-center 10'>
                        {masterclasse.name}
                    </NavLink>
                ))
                */
            }

            <span>{returnMessage}</span>
            <form onSubmit={handleSubmit}>
                <label htmlFor='message' className='form-label'>Ajoutez un compositeur</label>
                <input type="text" className='w-75 mb-5 d-block form-control' id='compositeurName'
                        onChange={handleChangeName} value={instrumentName}/>
            </form>
        </div>
    );
};

export default Instrument;
