import {useParams} from "react-router-dom";
import { useState, useEffect, useRef } from "react";
import {NavLink, useHistory} from "react-router-dom";
import RouteLink from "../../components/Route/RouteLink";
import GetUserIsAdmin from "../../components/User/GetUserIsAdmin";
import useGetMasterclass from "../../Hook/useGetMasterclass";
import useGetMasterclassCentreDeFormation from "../../Hook/useGetMasterclassCentreDeFormation";
import OthersMasterclass from "../../components/Masterclass/OthersMasterclass";
//import MasterclassDetails from "../MasterclassDetails/MasterclassDetails";
import useMasterclassQuizzes from "../../Hook/useGetMasterclassQuizz";
import useDeleteMasterclass from "../../Hook/useDeleteMasterclass";
import {GiDiploma,GiMusicalNotes} from "react-icons/gi";
const Masterclass = () => {
    const {id} = useParams();
    const [masterclass, setMasterclass] = useState([]);
    const [centre_formation, setCentre_formation] = useState([]);

    const [quizzes, setQuizzes] = useState([]);

    const getMasterclass = useGetMasterclass();
    const getMasterclassCentreDeFormation = useGetMasterclassCentreDeFormation();
    const getMasterclassQuizzes = useMasterclassQuizzes(id);

    const [returnMessage, setReturnMessage] = useState('');
    const deleteMasterclass = useDeleteMasterclass();

    useEffect(() => {
        Promise.all([
            getMasterclassCentreDeFormation(id),
            getMasterclass(id),
            getMasterclassQuizzes(id)
        ]).then(([cDf, masterLcass,masterclassQuizzes]) => {
            setMasterclass(masterLcass.masterclass)
            setCentre_formation(cDf.centre_formation)
            setQuizzes(masterclassQuizzes.quizzes)
        })
    }, [id]);


    const history = useHistory();
    const handleDeleteMasterclass = (e) => {
        deleteMasterclass(id).then(data => {
            setReturnMessage(data.message);

            if(data.message == "Masterclass Delete") {
                history.push('/Masterclasses', { replace: true });
            }
        });
    }

    return (
      <div className="w-full px-4 lg:px-16 md:px-16">
       <div className="flex items-center justify-start pt-10">
                <RouteLink text="Accueil" nav_link="/"></RouteLink>
                <svg className="mr-3 stroke-mid_primary_first" xmlns="http://www.w3.org/2000/svg" height="0.7em" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
                <RouteLink text="Masterclass" nav_link="/masterclasses"></RouteLink>
                <svg className="mr-3 stroke-mid_primary_first" xmlns="http://www.w3.org/2000/svg" height="0.7em" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
                <RouteLink text={masterclass.title} nav_link="#"></RouteLink>

            </div>
        <div className="flex flex-col my-12">
            <h1 className='text-3xl text-primary_first font-black'>{masterclass.title}</h1>
            {masterclass.Instrument ?
            <NavLink to={`/instrument/${masterclass.Instrument.id}`}
                        className="text-mid_neutral text-sm">
                {masterclass.Instrument.name}
            </NavLink> : <span></span>
            }
        </div>
        {GetUserIsAdmin() && (
        <div className="grid gap-x-16 my-4 lg:flex md:flex">
            <div className='w-auto lg:w-1/2 md:w-1/2'>
                <p className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded"
                    onClick={handleDeleteMasterclass}
                >
                    Supprimer
                </p>
            </div>
            <div className='w-auto lg:w-1/2 md:w-1/2'> 
            <NavLink to={`/update_masterclass/${id}`}
                className="bg-mid_primary_first text-ligther_neutral w-max font-bold py-2 px-6 border border-blue-700 rounded">
                Mettre à jour
            </NavLink>
            </div>
        </div>
        )}
        <span className=''>{returnMessage}</span>

        <div className="grid gap-x-16 my-4 lg:flex">
            <div className='w-auto lg:w-2/3'>
                <h2 className="text-2xl font-bold text-mid_primary_first font-black">Description</h2>
                <p className="text-sm">{masterclass.description}</p>                
            </div>
            <div className='w-auto lg:w-1/3'>
                <div className="flex flex-row items-center gap-10 py-4">
                <GiDiploma fontSize={30}/>
                <h2 className="text-2xl font-bold text-dark_primary_first font-black">
                    Centre de formation
                </h2>
                </div>
                
                <div className='flex flex-col text-sm'>
                <p className='text-sm'>{centre_formation.email}</p>  
                {/*<MasterclassDetails></MasterclassDetails>*/}       
                </div> 

                {quizzes.length > 0 ? (
            <div>
                <div className="flex flex-row items-center gap-10 py-4">

                    <GiMusicalNotes fontSize={30}/>
                    <h2 className="text-2xl font-bold text-dark_primary_first font-black">Quizz</h2>
                </div>
   
            <div className="flex flex-col text-sm">
              {quizzes.map((quiz) => (
                <li key={quiz.id} className="quizz-display">
                  <span>{quiz.name}</span>
                  <span>{quiz.counter}</span>
                  <NavLink to={`/masterclassQuizz/${quiz.id}`} className={"boutton-quizz"}>Commencer le quizz</NavLink>

                </li>
              ))}
            </div>
            </div>
          ) : (<div></div>)}
                
            </div>
        </div>
        <OthersMasterclass id={centre_formation.id} type="centre_formation"></OthersMasterclass>
      </div>
  );
};

export default Masterclass;
