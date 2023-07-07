import {useParams} from "react-router-dom";
import { useState, useEffect, useRef } from "react";
import {NavLink} from "react-router-dom";

import useGetMasterclass from "../../Hook/useGetMasterclass";
import useGetMasterclassCentreDeFormation from "../../Hook/useGetMasterclassCentreDeFormation";
import OthersMasterclass from "../../components/Masterclass/OthersMasterclass";
//import MasterclassDetails from "../MasterclassDetails/MasterclassDetails";

const Masterclass = () => {
    const {id} = useParams();
    const [masterclass, setMasterclass] = useState([]);
    const [centre_formation, setCentre_formation] = useState([]);
    const getMasterclass = useGetMasterclass();
    const getMasterclassCentreDeFormation = useGetMasterclassCentreDeFormation();
  
    useEffect(() => {
        Promise.all([
            getMasterclassCentreDeFormation(id),
            getMasterclass(id),
        ]).then(([cDf, masterLcass]) => {
            setMasterclass(masterLcass.masterclass)
            setCentre_formation(cDf.centre_formation)
        })
    }, [id]);

    console.log(masterclass);
  return (
      <div className="w-full px-4 lg:px-16 md:px-16">
        <NavLink to={`/masterclasses`}
                    className="">
            Revoir la liste des masterclasses
        </NavLink>
        <div className="flex flex-col my-12">
            <h1 className='text-3xl text-primary_first font-black'>{masterclass.title}</h1>
            {masterclass.Instrument ?
            <NavLink to={`/instrument/${masterclass.Instrument.id}`}
                        className="text-mid_neutral text-sm">
                {masterclass.Instrument.name}
            </NavLink> : <span></span>
            }
        </div>
        <div className="grid gap-x-16 my-4 lg:flex">
            <div className='w-auto lg:w-2/3'>
                <h2 className="text-2xl font-bold text-mid_primary_first font-black">Description</h2>
                <p className="text-sm">{masterclass.description}</p>                
            </div>
            <div className='w-auto lg:w-1/3'>
                <h2 className="text-2xl font-bold text-dark_primary_first font-black">Centre de formation</h2>
                <div className='flex flex-col text-sm'>
                <p className='text-sm'>{centre_formation.email}</p>  
                {/*<MasterclassDetails></MasterclassDetails>*/}       
                </div>     
            </div>
        </div>

        <OthersMasterclass id={centre_formation.id} type="centre_formation"></OthersMasterclass>
      </div>
  );
};

export default Masterclass;
