
import { AfterViewInit, Component } from '@angular/core';
import { ApiService } from "../shared/services/api.service";
import { ServersList } from "./interfaces/servers.interfaces";


@Component({
  selector: 'servers',
  styleUrls: ['servers.component.scss'],
  templateUrl: 'servers.component.html'
})
export class ServersComponent implements AfterViewInit {
  displayedColumns: string[] = ['model_name', 'ram_size', 'ram_type', 'hdd_type', 'hdd_size', 'location', 'price'];
  isLoadingResults = false;
  data: ServersList[] = [];
  ram_type: any;
  ram_size: any;
  hdd_type: any;
  hdd_size: any;
  ram_types: any = [  {'id': 'None', 'value': ''}, {'id':'DDR3', 'value': 'DDR3'}, {'id':'DDR4', 'value': 'DDR4'}];
  hdd_types: any = [  {'id': 'None', 'value': ''}, {'id':'SAS', 'value': 'SAS'}, {'id':'SATA', 'value': 'SATA'}, {'id':'SSD', 'value': 'SSD'}];
  ram_sizes:any = [
    {'id': 'None', 'value': ''},
    {'id':'0', 'value': 'O'},
    {'id':'250GB', 'value': '250GB'},
    {'id':'500GB', 'value': '500GB'},
    {'id':'1TB', 'value': '1TB'},
    {'id':'2TB', 'value': '2TB'},
    {'id':'3TB', 'value': '3TB'},
    {'id':'4TB', 'value': '4TB'},
    {'id':'8TB', 'value': '8TB'},
    {'id':'12TB', 'value': '12TB'},
    {'id':'24TB', 'value': '24TB'},
    {'id':'48TB', 'value': '48TB'},
    {'id':'78TB', 'value': '78TB'},
  ];

  hdd_sizes:any = [
    {'id': 'None', 'value': ''},
    {'id':'2GB', 'value': '2GB'},
    {'id':'4GB', 'value': '4GB'},
    {'id':'8GB', 'value': '8GB'},
    {'id':'12GB', 'value': '12GB'},
    {'id':'16GB', 'value': '16GB'},
    {'id':'24GB', 'value': '24GB'},
    {'id':'32GB', 'value': '32GB'},
    {'id':'48GB', 'value': '48GB'},
    {'id':'64GB', 'value': '64GB'},
    {'id':'96GB', 'value': '96GB'},
  ];

  constructor(private apiService: ApiService) {}

  ngAfterViewInit() {
     this.getServersList();
  }

  getServersList(params = {}) {
    this.apiService.get('servers/list', params)
        .subscribe((res) => {
          this.data = res.data;
        });
  }

  applyFilter(obj) {
    this.getServersList(obj);
  }
}




