import React, {Component} from 'react';
import Chart from "react-google-charts";

class StatisticView extends Component {

    render() {
        return (
            <div>
                <h1>Статистика</h1>
                <div className={"my-pretty-chart-container"}>
                    <Chart
                        chartType="ScatterChart"
                        data={[["Age", "Weight"], [4, 5.5], [8, 12]]}
                        width="100%"
                        height="400px"
                        legendToggle
                    />
                </div>
            </div>
        );
    }

}

export default StatisticView;
