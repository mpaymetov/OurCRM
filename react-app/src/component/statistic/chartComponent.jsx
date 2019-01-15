import React, {Component} from 'react';
import Chart from "react-google-charts";

class ChartComponent extends Component {

    constructor(props) {
        super(props);
        this.state = {jsonData: ''};
    }

    componentWillMount() {
         fetch(this.getApi(this.props.type))
             .then(response => response.json())
             .then(data => this.setState({jsonData: data.info}))
             .catch((error) => {
                 console.error(error);
             });
    }

    getApi(type)
    {
        if(this.props.type !== '') {
            let Api = '';
            switch (type) {
                case 'serviceset':
                    Api = '/api/statistics/render-initial-serviceset-chart';
                    break;
                case 'project':
                    Api = '/api/statistics/render-initial-project-chart';
                    break;
                case 'sale':
                    Api = '/api/statistics/render-initial-sale-chart';
                    break;
            }
            return Api;
        }
    }

    render() {

        if (this.state.jsonData !== '') {
            console.log(this.state.jsonData);
            var typeName = this.state.jsonData.chart;
            var arr = this.state.jsonData.data;

            return (
                <div>
                <h2>{this.state.jsonData.title}</h2>
                    <div>
                        <Chart
                            chartType={typeName}
                            width="100%"
                            height="400px"
                            data={arr}
                        />
                    </div>
                </div>
            );
        } else {
            return(
              <div></div>
            );
        }
    }

}

export default ChartComponent;
