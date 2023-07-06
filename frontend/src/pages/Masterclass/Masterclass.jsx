import {useParams} from "react-router-dom";
import { useState, useEffect, useRef } from "react";
import {NavLink} from "react-router-dom";

import useGetMasterclass from "../../Hook/useGetMasterclass";
import useGetMasterclassCentreDeFormation from "../../Hook/useGetMasterclassCentreDeFormation";
import OthersMasterclass from "../../components/Masterclass/OthersMasterclass";
//import MasterclassDetails from "../MasterclassDetails/MasterclassDetails";

const Masterclass = () => {
    const isMounted = useRef(false)
    const {id} = useParams();
    const [masterclass, setMasterclass] = useState([]);
    const [centre_formation, setCentre_formation] = useState([]);
    const getMasterclass = useGetMasterclass();
    const getMasterclassCentreDeFormation = useGetMasterclassCentreDeFormation();
  
    useEffect(() => {
        if (isMounted.current === false) {
            Promise.all([
                getMasterclassCentreDeFormation(id),
                getMasterclass(id),
            ]).then(([cDf, masterLcass]) => {
                setMasterclass(masterLcass.masterclass)
                setCentre_formation(cDf.centre_formation)
            })
            isMounted.current = true
        }
    }, []);

  return (
      <div className="w-fit lg:mx-16">
        <NavLink to={`/masterclasses`}
                    className="">
            Revoir la liste des masterclasses
        </NavLink>
          <h1 className='text-3xl my-12 text-primary_first font-black'>{masterclass.title}</h1>
          <div className="grid gap-x-16 my-4 lg:flex">
              <div className='w-auto lg:w-2/3'>
                  <h2 className="text-2xl font-bold text-mid_primary_first font-black">Description</h2>
                  <p className="text-sm">{masterclass.description}</p>                
              </div>
              <div className='w-auto lg:w-1/3'>
                  <h2 className="text-2xl font-bold text-dark_primary_first font-black">Centre de formation</h2>
                  <div className='flex flex-col'>
                  <p>{centre_formation.email}</p>  
                  {/*<MasterclassDetails></MasterclassDetails>*/}       
                  </div>     
              </div>
          </div>

          <OthersMasterclass id={centre_formation.id} type="centre_formation"></OthersMasterclass>
      </div>
  );
};

export default Masterclass;
