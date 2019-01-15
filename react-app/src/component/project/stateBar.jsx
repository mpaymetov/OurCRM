import React, {Component} from 'react';
import StateItem from './stateItem.jsx'


class StateBar extends Component {


    stateListElem(set, listNum) {
        var elem = {
            curr: set.currState,
            prev: set.prevState,
            listElem: listNum,
            setIsOpen: set.setIsOpen
        }
        return elem;
    }


    render() {

        if(this.props.set !== '') {

            var arr = this.props.set.stateList;

            var list = arr.map(
                (item) =>  this.stateListElem(this.props.set, item));

            let classNameDiv = "btn-group btn-group-justified status-bar-" + this.props.set.idServiceset;

            return (
                <div className={classNameDiv}>
                    {list.map((item) => <StateItem item = {item} />)}
                </div>
            );
        } else {
            return (
                <div></div>
            );
        }
    }

}

export default StateBar;