import React, {Component} from 'react';
import ChartComponent from './chartComponent.jsx';

class StatisticView extends Component {

    render() {

        return (
            <div className={"container"}>
                <ChartComponent type = {'serviceset'}/>
                <ChartComponent type = {'project'}/>
                <ChartComponent type = {'sale'}/>
            </div>
        );
    }

}

export default StatisticView;
