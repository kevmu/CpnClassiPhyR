#!/usr/local/bin/python3.5

import sys
import os
import argparse

import re
import csv

from Bio import SeqIO

# Need to set matplotlib to use 'Agg' so that xwindows is not active and gel images can be generated.
import matplotlib
matplotlib.use('Agg')

python_path = sys.argv[0]
app_dir = os.path.dirname(os.path.realpath(python_path))
sys.path.append(os.path.abspath(app_dir))

from CpnClassiPhyR import *

parser = argparse.ArgumentParser()

fasta_infile = None
output_dir = None

parser.add_argument('-i', action='store', dest='fasta_infile',
                    help='fasta file as input. (i.e. filename.fasta)')
parser.add_argument('-o', action='store', dest='output_dir',
                    help='output directory as input. (i.e. $HOME)')

parser.add_argument('--version', action='version', version='%(prog)s 1.0')

results = parser.parse_args()

fasta_infile = results.fasta_infile
output_dir = results.output_dir

if(fasta_infile == None):
    print('\n')
    print('error: please use the -i option to specify the fasta file as input')
    print('fasta_infile =' + ' ' + str(fasta_infile))
    print('\n')
    parser.print_help()
    sys.exit(1)
if(output_dir == None):
    print('\n')
    print('error: please use the -o option to specify the output directory as input')
    print('output_dir =' + ' ' + str(output_dir))
    print('\n')
    parser.print_help()
    sys.exit(1)


if not os.path.exists(output_dir):
    os.makedirs(output_dir)

# Initialize CpnClassiPhyR
CpnClassiPhyR = CpnClassiPhyR()

#target_infile = os.path.join(app_dir, 'db', 'cpndb_nuc_phytoplasmas-2018-02-05.fasta')
#target_infile = os.path.join(app_dir, 'db', 'cpndb_nr_phyto_nuc.fasta')
target_infile = os.path.join(app_dir, 'db', 'cpndb_phyto_nr.fasta')
#print(fasta_infile)

#print(target_infile)
cpnidentiphyr_output_dir = os.path.join(output_dir, 'CpnIdentiPhyR')
if not os.path.exists(cpnidentiphyr_output_dir):
    os.makedirs(cpnidentiphyr_output_dir)

CpnIdentiPhyR_infile = CpnClassiPhyR.CpnIdentiPhyR(fasta_infile, target_infile, cpnidentiphyr_output_dir)

print(CpnIdentiPhyR_infile)
#sys.exit()
subgroup_metadata_dir = 'subgroup_metadata'
subgroup_RFLP_digests = {}
json_subgroup_metadata_infile = os.path.join(app_dir, subgroup_metadata_dir, 'json', 'subgroup_RFLP_digests.json')
with open(json_subgroup_metadata_infile) as subgroup_metadata_file:
    subgroup_RFLP_digests = json.load(subgroup_metadata_file)


#print(subgroup_RFLP_digests)
#sys.exit()
RFLP_digests = CpnClassiPhyR.RFLP_digests(CpnIdentiPhyR_infile)

#print(RFLP_digests)
all_RFLP_digests = RFLP_digests.copy()
all_RFLP_digests.update(subgroup_RFLP_digests)

strain_list = sorted(list(RFLP_digests.keys()))

subgroup_list = sorted(list(subgroup_RFLP_digests.keys()))

all_strains_list = sorted(list(all_RFLP_digests.keys()))

strain_metadata_dir = os.path.join(output_dir, 'metadata')
if not os.path.exists(strain_metadata_dir):
    os.makedirs(strain_metadata_dir)

data_dir = os.path.join(strain_metadata_dir, 'data')
if not os.path.exists(data_dir):
    os.makedirs(data_dir)

num_bands_outfile = os.path.join(data_dir, 'num_bands.csv')
f = open(num_bands_outfile, 'w')
num_bands_output_file = csv.writer(f)

header = []
renzyme_list = sorted(CpnClassiPhyR.renzymes)
for renzyme in renzyme_list:
    header.append(renzyme + ' ' + 'Band Sizes')
    header.append(renzyme + ' ' + 'Number of Bands')

num_bands_output_file.writerow(['cpn60 UT', 'Strain'] + header)

for strain in all_strains_list:
    RFLP_digest = all_RFLP_digests[strain]
    phyto_strain_desc = RFLP_digest['Description']
    line = []
    for renzyme in renzyme_list:
        line.append(RFLP_digest[str((renzyme,'Band Sizes'))])
        line.append(RFLP_digest[str((renzyme,'Number of Bands'))])
    
    num_bands_output_file.writerow([strain, phyto_strain_desc] + line)

sc_matrix_data = CpnClassiPhyR.similarity_coefficient_matrix(all_RFLP_digests)
f.close()

matrix_outfile = os.path.join(data_dir, 'similarity_coefficient_matrix.csv')
f = open(matrix_outfile, 'w')
matrix_output_file = csv.writer(f)
matrix_output_file.writerow(['cpn60 UT'] + all_strains_list)

#print(strain_list)
strain_sc_matrix_data = {}
for strain_x in all_strains_list:
    line = []
    line.append(strain_x)
    for strain_y in all_strains_list:
        
#        print('First: {0[0]}, Second: {0[1]}'.format((strain_x,strain_y)))
#        print(sc_matrix_data[str((strain_x,strain_y))])

        line.append(sc_matrix_data[str((strain_x,strain_y))]['F Value'])
        strain_sc_matrix_data[str((strain_x, strain_y))] = sc_matrix_data[str((strain_x,strain_y))]['F Value']
    
    matrix_output_file.writerow(line)
f.close()

best_subgroup_matches = {}
for strain_x in strain_list:
    current_subgroup_F_value = 0.0
    current_subgroup_strain = ""
    for strain_y in subgroup_list:
        
#        print('First: {0[0]}, Second: {0[1]}'.format((strain_x,strain_y)))
#        print(sc_matrix_data[str((strain_x,strain_y))])

        F_value = float(sc_matrix_data[str((strain_x,strain_y))]['F Value'])
        if(F_value > current_subgroup_F_value):
            current_subgroup_F_value = F_value
            current_subgroup_strain = strain_y
    best_subgroup_matches[strain_x] = current_subgroup_strain
#    print("strain_x: " + strain_x + ", " + best_subgroup_matches[strain_x])

subgroup_matches_outfile = os.path.join(data_dir, 'subgroup_matches.csv')
f = open(subgroup_matches_outfile, 'w')
subgroup_matches_output_file = csv.writer(f)
subgroup_matches_output_file.writerow(['Strain', 'Best Match', 'Similarity Coefficient Calculation', 'F Value', 'Classification'])
for strain_x in strain_list:
    strain_y = best_subgroup_matches[strain_x]
    
    classification = ""
    f_value_calc = float(sc_matrix_data[str((strain_x,strain_y))]['F Value'])
    
    group = strain_y.split('-')[0]
    subgroup = strain_y.split('-')[1]
    if(f_value_calc < 0.59):
        classification = "Probable new Cpn60 UT group"
    elif(f_value_calc >= 0.59):
        if(f_value_calc < 0.97):
            classification = "Probable new subgroup in Cpn60 UT " + group
        
        elif(f_value_calc >= 0.97):
            classification = "Closest match is Cpn60 UT " + strain_y
        
            if(f_value_calc == 1.00):
                classification = "Exact match to Cpn60 UT " + strain_y


    subgroup_matches_output_file.writerow([strain_x, strain_y, "F = ( 2 * " + str(sc_matrix_data[str((strain_x,strain_y))]['Nxy']) + " ) / ( " + str(sc_matrix_data[str((strain_x,strain_y))]['Nx']) + " + " + str(sc_matrix_data[str((strain_x,strain_y))]['Ny']) + " )", f_value_calc, classification])
f.close()



virtual_gel_image_dir = os.path.join(strain_metadata_dir, 'gels')
if not os.path.exists(virtual_gel_image_dir):
    os.makedirs(virtual_gel_image_dir)

strain_RFLP_digest_data = RFLP_digests
for strain in strain_list:
    RFLP_digest = RFLP_digests[strain]
    strain_RFLP_digest = strain_RFLP_digest_data[strain]
    phyto_strain_desc = RFLP_digest['Description']
#    print(strain)
#    print(phyto_strain_desc)
    xlabel = strain + ", cpn60 UT " + best_subgroup_matches[strain]
    virtual_gel_filepath = CpnClassiPhyR.draw_gel(RFLP_digests[strain],xlabel,virtual_gel_image_dir)
    
    strain_RFLP_digest['Virtual Gel Filepath'] = virtual_gel_filepath
    
    strain_RFLP_digest_data[strain] = strain_RFLP_digest


json_dir = os.path.join(strain_metadata_dir, 'json')
if not os.path.exists(json_dir):
    os.makedirs(json_dir)

strain_RFLP_digests_infile = os.path.join(json_dir, 'RFLP_digests.json')
strain_RFLP_digests_file = open(strain_RFLP_digests_infile, "w+")
strain_RFLP_digests_file.write(json.dumps(strain_RFLP_digest_data, indent=4))
strain_RFLP_digests_file.close()

strain_sc_matrix_infile = os.path.join(json_dir, 'sc_matrix.json')
strain_sc_matrix_file = open(strain_sc_matrix_infile, "w+")
strain_sc_matrix_file.write(json.dumps(strain_sc_matrix_data, indent=4))
strain_sc_matrix_file.close()


