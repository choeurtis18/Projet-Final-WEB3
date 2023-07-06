import AddInstrument from "../../components/Instrument/AddInstrument";
import Get_InstrumentList from "../../components/Instrument/InstrumentList";

const InstrumentList = () => {
    return (
        <div className="w-full">
            <Get_InstrumentList ></Get_InstrumentList>
            <AddInstrument></AddInstrument>
        </div>
    );
};

export default InstrumentList;
