import React, {Component} from 'react';
import ChartComponent from './chartComponent.jsx';

class StatisticView extends Component {

    constructor(props) {
        super(props);
        this.state = {jsonData: ''};
    }

    componentWillMount() {
        fetch('/api/statistics')
            .then(response => response.json())
            .then(data => this.setState({jsonData: data.model}))
            .catch((error) => {
                console.error(error);
            });
    }

    mergeInfo(item, list, statistic) {
        var result = {
            type: item,
            form: {
                list: list,
                statisticType: statistic
            }
        };
        return result;
    }

    getChartInfo() {
        const chartType = ['serviceset', 'project', 'sale'];
        const el = chartType.map((item) => this.mergeInfo(item, this.state.jsonData.managerList, this.state.jsonData.statisticType))
        return el;
    }


    render() {
        if (this.state.jsonData !== '') {
            var arr = this.getChartInfo();

            //console.log(arr);
            return (
                <div className={"container"}>
                    {arr.map((item) => <ChartComponent info = {item}/>)}
                </div>
            );
        } else {
            return (
                <div></div>
            );
        }
    }

}

export default StatisticView;
