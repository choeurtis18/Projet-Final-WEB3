import Get_EventList from "../../components/Event/EventList";
import RouteLink from "../../components/Route/RouteLink"
import ActionButton from "../../components/Buttons/ActionButton"

const EventList = () => {
    return (
        <div className="w-full p-20">
            <div className="flex items-center justify-start">
                <RouteLink text="Accueil" nav_link="/"></RouteLink>
                <svg className="mr-3 stroke-mid_primary_first" xmlns="http://www.w3.org/2000/svg" height="0.7em" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
                <RouteLink text="Evénements" nav_link="#"></RouteLink>
            </div>
            <div className="my-6 flex flex-wrap items-center justify-end">
                <ActionButton text="Ajouter un événement" nav_link={`/add_event/`}></ActionButton>
            </div>
            <div className="w-full">
                <h1 className='text-3xl mt-6 mb-1 font-medium text-primary_first font-black'>Evénements</h1>
                <Get_EventList ></Get_EventList>
            </div>
        </div>
    );
};

export default EventList;
