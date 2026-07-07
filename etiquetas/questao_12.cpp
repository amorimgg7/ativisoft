#include <iostream>
#include <omp.h>

int main(){
	omp_set_num_threads(4);

	#pragma omp parallel
	{
		int id = omp_get_thread_num();
		
		#program omp critical
		std::cout << "Olá mundo: " << id << std::endl;
	}
	return 0;
}
