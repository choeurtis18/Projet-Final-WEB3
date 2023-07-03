import { useState, useEffect } from "react";
//import {NavLink} from "react-router-dom";
import useGetInstrumentList from "../../Hook/useGetInstrumentList";

const InstrumentList = ({ questions }) => {
  const [instrumentList, setInstrumentList] = useState([]);

  const getInstrumentList = useGetInstrumentList();

  useEffect(() => {
    getInstrumentList().then(data => {
      setInstrumentList(data.instruments);
    });
  }, [])

  return (
    <div>
        <h1 className='m-5 text-center'>Instruments</h1>
        {instrumentList.map((instrument, index) => (
          <span key={index}>{instrument.name}</span>
          /*
            <NavLink key={index} to={`/instrument/${instrument.id}`}
                        className='text-black text-decoration-none w-100 d-block text-center 10'>
                {instrument.name}
            </NavLink>
          */

        ))}
    </div>
  );
};

export default InstrumentList;
