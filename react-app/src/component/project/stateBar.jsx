import React, {Component} from 'react';
import StateItem from './stateItem.jsx'


class StateBar extends Component {


    stateListElem(currState, listNum) {
        var elem = {
            curr: currState,
            listElem: listNum
        }
        return elem;
    }


    render() {

        if(this.props.set !== '') {

            var arr = this.props.set.stateList;

            var list = arr.map(
                (item) =>  this.stateListElem(this.props.set.currState, item));

            return (
                <div className="btn-group btn-group-justified status-bar">
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