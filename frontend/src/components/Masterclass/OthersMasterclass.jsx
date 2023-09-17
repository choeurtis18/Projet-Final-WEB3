import { useState, useEffect } from "react";
import { NavLink } from "react-router-dom";

import useGetMasterclassByInstruments from "../../Hook/useGetMasterclassByInstruments";
import useGetMasterclassByComposer from "../../Hook/useGetMasterclassByComposer";
import useGetMasterclassByCentreFormation from "../../Hook/useGetMasterclassByCentreFormation";

export default function OthersMasterclass(props) {
    const [masterclasses, setMasterclasses] = useState([]);
    var getMasterclasses;

    if(props.type == "instrument") {
        getMasterclasses = useGetMasterclassByInstruments();   
    } else if(props.type == "composer") {
        getMasterclasses = useGetMasterclassByComposer();   
    } else if(props.type == "centre_formation") {
        getMasterclasses = useGetMasterclassByCentreFormation();   
    }

    useEffect(() => {
        if (props.id === undefined) return

        getMasterclasses(props.id).then(data => {
            setMasterclasses(data.masterclasses);
        });
    }, [props]);


    return (
        <div className="flex flex-col my-4 lg:flex md:flex">
            <h2 className='text-2xl my-8 font-medium text-mid_primary_second font-black'>Les autres masterclasses</h2>
            <div className='flex flex-wrap gap-4'>
            {
                masterclasses.map((masterclasse, index) => (
                    <NavLink key={index} to={`/masterclass/${masterclasse.id}`}
                        className="w-fit border border-mid_primary_second rounded-lg p-4 lg:w-1/4 bg-ligther_primary_second grid gap-y-2 card-page">
                        <h3 className="text-xl font-black text-mid_primary_second font-black">{masterclasse.title}</h3>
                        <p className="text-sm">{masterclasse.description.substring(0, 100)}</p>
                    </NavLink>
                ))
            }
            </div>     
        </div>
    );
};
