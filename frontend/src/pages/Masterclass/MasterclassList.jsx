import AddMasterclass from "../../components/Masterclass/AddMasterclass";
import Get_MasterclassList from "../../components/Masterclass/MasterclassList";

const MasterclassList = () => {
    return (
        <div className="w-full">
            <Get_MasterclassList></Get_MasterclassList>
            <AddMasterclass></AddMasterclass>
        </div>
    );
};

export default MasterclassList;
